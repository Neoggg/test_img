#!/usr/local/bin/perl
$|=1;
use POSIX qw(strftime);
use Net::FTP;
use LWP::UserAgent;

@pws=getpwnam('webuser');
$webuserhome=$pws[7];

$include_sub_dir="/pec_payment/include/";
require $webuserhome.$include_sub_dir."pre_require.pl";
if ($host_name =~ /$dev_env_str/) {  # 開發環境
  require $webuserhome.$include_sub_dir."config_dev.pl";
}
else {                               # 正式環境
  require $webuserhome.$include_sub_dir."config.pl";
}
require $webuserhome.$include_sub_dir."pool.pl";
require $webuserhome.$include_sub_dir."fun_payment.pl";

$oq_not_auto_exit=1;  # fun_payment.pl 不自動exit
$bank_code="013";
$bank_pid="UWCCB";
$atm_filedir=$_chkatm_log_path.$bank_pid."/atm_backup/";
$log_filedir=$_chkatm_log_path.$bank_pid."/log_backup/";
$date_eclog=strftime("%Y%m%d",localtime(time - (86400 * 3)));
$atm_str="";
$sleep_sec=60;
my @wchal_arr,@wurl_arr,@wdir_arr,@ec_source_array,@rday_arr,$tstrmg,$run_type,$runend_str,$save_fn,$real_acc,$ec_src,$insert_n;

# 帶入參數
$arg_option=shift @ARGV;
$channel_src=shift @ARGV;

if ($arg_option eq "" || $channel_src eq "") {
  print <<PARA;
使用方式:

開發環境:
  核帳 - 國泰世華 PEC :
    ./uwccb_check_atm.pl uwccbatm|20080910 PEC >> /export/home/webuser/pec_payment/log-dev/check_atm_log/UWCCB/uwccb_check_atm_pec_`date \\+\\%Y\\%m\\%d.log`

正式環境:
  核帳 - 國泰世華 PEC :
    ./uwccb_check_atm.pl uwccbatm|20080910 PEC >> /export/home/webuser/pec_payment/log-regular/check_atm_log/UWCCB/uwccb_check_atm_pec_`date \\+\\%Y\\%m\\%d.log`

參數:
uwccbatm: 到國泰世華的 URL 抓核帳資料
日期: 用 payment 上的檔案"補"核帳

PARA
  exit;
}

if ($arg_option eq "uwccbatm") {
  $tstrmg="核帳";
  $run_type="normal";

  for (my $iv=0; $iv<3; $iv++) {  # 核3天內的帳 
    $rday_arr[$iv]=strftime("%Y%m%d",localtime(time - (86400 * $iv)));
  }
}
else {
  $tstrmg='"補"核帳';
  $run_type="reins";
}

if ($channel_src eq "ALL") {
  @ec_source_array=sort keys %_uwccb_chkatm_url;
  for (my $iv=0; $iv<=$#ec_source_array; $iv++) {  
    $wchal_arr[$iv]=$ec_source_array[$iv];
    if ($run_type eq "normal") {
      $wurl_arr[$iv]=$_uwccb_chkatm_url{$ec_source_array[$iv]};  # 取出各來源服務核帳的URL
    }
    elsif ($run_type eq "reins") {
      $wdir_arr[$iv]=$atm_filedir.$ec_source_array[$iv]."/".substr($arg_option,0,6)."/".$arg_option.".dat";
    }
  }
}
else {
  $wchal_arr[0]=$channel_src;
  if ($run_type eq "normal") {    
    $wurl_arr[0]=$_uwccb_chkatm_url{$channel_src};
  }
  elsif ($run_type eq "reins") {
    $wdir_arr[0]=$atm_filedir.$channel_src."/".substr($arg_option,0,6)."/".$arg_option.".dat";
  }
}

$poolh=connect_db();
if (!$poolh) {   
  print_status("ERROR: 連接 Oracle 失敗"); 
  print_status($pool_comm_err);
  print_status("");
  exit; 
}

for (my $iv=0; $iv<=$#wchal_arr; $iv++) {  
  $ec_src=$wchal_arr[$iv];
  print_status("*****************  國泰世華 ".$ec_src." ".$tstrmg."開始 *****************");
  $runend_str="*****************  國泰世華 ".$ec_src." ".$tstrmg."結束 *****************";
  
  if ($run_type eq "normal") {    # 到國泰世華網站核帳
    print_status("workurl: ".$wurl_arr[$iv]);    

    if ($wurl_arr[$iv] eq "") {
      print_status("ERROR: 核帳URL錯誤");
      print_status($runend_str);  print_status("");
      exit;
    }

    # 建立主目錄
    $chal_atm_dirn=$atm_filedir.$ec_src."/";
    if (! -e $chal_atm_dirn) {
      print_status("mkdir : ".$chal_atm_dirn);
      mkdir($chal_atm_dirn,0755); 
    }
    $eclog_dirn=$log_filedir.$ec_src."/";
    if (! -e $eclog_dirn) {
      print_status("mkdir : ".$eclog_dirn);
      mkdir($eclog_dirn,0755); 
    }

    $real_acc=$_uwccb_real_account{$ec_src};  # 實體帳戶帳號

    for (my $iq=0; $iq<=$#rday_arr; $iq++) {  
      #$work_url=$wurl_arr[$iv]."&acno=".$real_acc."&from_date=".$rday_arr[$iq]."&to_Date=".$rday_arr[$iq]."&from_time=000000&to_time=235959";
      $work_url=$wurl_arr[$iv];
      #$work_url = 'http://erp.mypchome.com.tw/test/atmcheck.php';
      #$work_param = "acno=".$real_acc."&from_date=".$rday_arr[$iq]."&to_Date=".$rday_arr[$iq]."&from_time=000000&to_time=235959";
      $work_param = [ 'acno'=>$real_acc, 'from_date'=>$rday_arr[$iq], 'to_date'=>$rday_arr[$iq], 'from_time'=>'000000', 'to_time'=>'235959',
          'cust_id'=>'166061020106', 'cust_pwd'=>'st11111', 'cust_nickname'=>'st22222', 'xml'=>'n', 'txdate8'=>'Y'  ];
      
      print_status("POST ".$rday_arr[$iq]." : ".$work_url);
      get_uwccb_atm_url($work_url, $work_param);        # 執行核帳
      if (check_uwccb_atm_data($real_acc)) {            # 檢查回傳的資料格式
      	if ($iq < $#rday_arr) {  # 國泰世華會檔每次查詢間隔要1分鐘 
          print_status("sleep(".$sleep_sec.")");  print_status("");  sleep($sleep_sec);
        }
        next;
      }
      $save_fn=mkdir_backup($rday_arr[$iq],$ec_src);    # 備份的日期目錄不存在則建立
      $save_fn.=$rday_arr[$iq].".dat";                  # 備份的檔名
      save_atm_backup_file($save_fn);                   # 將取回的資料存成檔案備查
      $insert_n=insert_uwccb_record($ec_src,$save_fn);  # 將檔案內容寫入DB
      print_status("本次新增 $insert_n 筆");
      if ($iq < $#rday_arr) {  # 國泰世華會檔每次查詢間隔要1分鐘        
        print_status("sleep(".$sleep_sec.")");  print_status("");  sleep($sleep_sec);
      }
    }
  }
  elsif ($run_type eq "reins") {  # 補核帳,用payment上的檔案
    print_status("workfile: ".$wdir_arr[$iv]);
    
    if (! -e $wdir_arr[$iv]) {
      print_status("ERROR: 補核帳檔案不存在");
      print_status($runend_str);  print_status("");
      exit;
    }

    $insert_n=insert_uwccb_record($ec_src,$wdir_arr[$iv]);  # 將檔案內容寫入DB
    print_status("本次新增 $insert_n 筆");
  }

  # 3天前的執行過程log檔搬目錄
  $bufs=$ec_src;
  $bufs =~ tr/A-Z/a-z/;
  $from_logfn=$_chkatm_log_path.$bank_pid."/uwccb_check_atm_".$bufs."_".$date_eclog.".log";
  $eclog_dirn=$log_filedir.$ec_src."/".substr($date_eclog,0,6)."/";  
  if (! -e $eclog_dirn) {
    print_status("mkdir : ".$eclog_dirn);
    mkdir($eclog_dirn,0755); 
  }
  if (-e $from_logfn) {
    $cmd=$_mv_prg." ".$from_logfn." ".$eclog_dirn;
    print_status($cmd);
    system($cmd);
  }

  print_status($runend_str);
  print_status("");
}

pool_close($poolh);

exit;


sub nowtime {
  @today=localtime(time); # 4728213021053880
  $s_ymd=($today[5]+1900).substr('0'.($today[4]+1),-2).substr('0'.$today[3],-2); # 20050330
  $s_ymdtime=($today[5]+1900).'/'.substr('0'.($today[4]+1),-2).'/'.substr('0'.$today[3],-2).' '.substr('0'.$today[2],-2).":".substr('0'.$today[1],-2).":".substr('0'.$today[0],-2); # 2005/03/30 21:28:47
  return $s_ymdtime;
}

sub query_error {
  nowtime();  
  print $s_ymdtime." ".$pool_comm_err."\n";
}

sub print_status {
  nowtime();
  print $s_ymdtime." ".$_[0]."\n";
}

sub get_uwccb_atm_url {
  my ($my_wurl, $my_param) = @_;
  my $ua,$req,$res;
  
  use  HTTP::Request::Common qw(POST);
  use LWP::UserAgent;
  $ua = LWP::UserAgent->new;
  
  my $req = POST $my_wurl, $my_param;
  #my $req = POST $my_wurl, 'a=xx&b=xx&c=xx';
   
  $res = $ua->request($req);
  $atm_str=$res->content;
  

  #$ua=LWP::UserAgent->new;  
  #$req=HTTP::Request->new(POST=>$my_wurl, [foo=>bar, bar=> fool]);

  #$res=$ua->request($req);
  #$atm_str=$res->content;

  return $atm_str;
}

sub check_uwccb_atm_data {
  my ($my_chacc) = @_;
  my $ret_fg;
print $atm_str."\n";
  if (substr($atm_str,0,12) ne $my_chacc) {  # 開始的12個字元不是實體帳戶帳號,表示內容有誤
    print_status("ERROR: 開始的12個字元不是實體帳戶帳號,取資料發生錯誤");
    print_status("ERROR MSG: ".substr($atm_str,0,128));
    $ret_fg=1;
  }
  else { 
    $ret_fg=0; 
  }

  return $ret_fg;
}

sub mkdir_backup {
  my ($my_ymd,$my_chal) = @_;
  my $month_sdir,$log_sdir;

  if (!($my_ymd =~ /^\d+$/i) || length($my_ymd) != 8) { 
    print "date format error"; 
    return; 
   }

  $month_sdir=$atm_filedir.$my_chal."/".substr($my_ymd,0,6)."/";  
  if (! -e $month_sdir) {
    print_status("mkdir : ".$month_sdir);
    mkdir($month_sdir,0755); 
  }

  $log_sdir=$log_filedir.$my_chal."/".substr($my_ymd,0,6)."/";  
  if (! -e $log_sdir) {
    print_status("mkdir : ".$log_sdir);
    mkdir($log_sdir,0755); 
  }

  return $month_sdir;
}

sub save_atm_backup_file {
  my ($my_sfn) = @_;
  my $SVFILE;

  open SVFILE, ">$my_sfn";
    print SVFILE $atm_str."\n";
  close SVFILE;  
}

sub insert_uwccb_record {
  my ($my_ec_src,$my_ufile) = @_;
  my $chg_tx_date,$runm=0;

  open (FILEHD, $my_ufile);
  while (<FILEHD>) {
    $_ =~ s/[\r\n]//g;

    # 001031004663,970919,00010,17AA,  ,        ,2,+,0000000000019,+,000000034654441,1077092090928783    ,001WX,全國繳費,013    ,                                                            ,0130000040566035768 ,005428,20100809
    ($uwccb_baccno,$uwccb_tx_date,$uwccb_tx_seqno,$uwccb_tx_idno,$uwccb_space,$uwccb_chno,$uwccb_dc,$uwccb_sign,$uwccb_amount,$uwccb_bsign,$uwccb_bamount,$uwccb_memo1,$uwccb_tx_mach,$uwccb_tx_spec,$uwccb_bankid,$uwccb_accname,$uwccb_memo2,$uwccb_tx_time,$mdf_uwccb_tx_date) = /(............)(......)(.....)(....)(..)(........)(.)(.)(.............)(.)(...............)(....................)(.....)(........)(.......)(............................................................)(....................)(......)(........)/;
    #print_status($uwccb_baccno.",".$uwccb_tx_date.",".$uwccb_tx_seqno.",".$uwccb_tx_idno.",".$uwccb_space.",".$uwccb_chno.",".$uwccb_dc.",".$uwccb_sign.",".$uwccb_amount.",".$uwccb_bsign.",".$uwccb_bamount.",".$uwccb_memo1.",".$uwccb_tx_mach.",".$uwccb_tx_spec.",".$uwccb_bankid.",".$uwccb_accname.",".$uwccb_memo2.",".$uwccb_tx_time.",".$mdf_uwccb_tx_date);
    next if ($uwccb_baccno eq "");

    # 國泰世華回傳多一個欄位 $mdf_uwccb_tx_date 因應民國百年位數不足問題
    $chg_tx_date=$mdf_uwccb_tx_date;
    $uwccb_tx_date=substr("0".(substr($mdf_uwccb_tx_date,0,4)-1911),-3).substr($mdf_uwccb_tx_date,4,4);  # 轉民國年
    
    # ATM核帳主檔
    $sqlstr="select count(*) from $_oracle_payment_user.check_atm_main t 
             where t.channel_src = '$my_ec_src' and t.user_acct = '$uwccb_memo1' and t.tx_date = '$chg_tx_date' and t.tx_time = '$uwccb_tx_time'";
    $sth=opool_query($sqlstr,$poolh) or query_error();
    @data=pool_fetch_row($sth);
    ($chksum)=@data;
    pool_free_result($sth);
    if ($chksum <= 0 && $chksum ne "") {
      $sqlstr="insert into $_oracle_payment_user.check_atm_main (channel_src,user_acct,tx_date,tx_time,bank_code,bank_pid,payment_ins_dt)
               values ('$my_ec_src','$uwccb_memo1','$chg_tx_date','$uwccb_tx_time','$bank_code','$bank_pid',TO_CHAR(sysdate,'YYYY/MM/DD HH24:MI:SS'))";
      #print $sqlstr."\n\n";
      $sth=opool_query($sqlstr,$poolh) or query_error();
    }

    # 國泰世華核帳檔
    $sqlstr="select count(*) from $_oracle_payment_user.check_atm_uwccb t
             where t.channel_src = '$my_ec_src' and t.uwccb_memo1 = '$uwccb_memo1' and atm_main_date = '$chg_tx_date' and uwccb_tx_time = '$uwccb_tx_time' and t.uwccb_baccno = '$uwccb_baccno' and t.uwccb_tx_seqno = '$uwccb_tx_seqno' and t.uwccb_tx_mach = '$uwccb_tx_mach'";
    $sth=opool_query($sqlstr,$poolh) or query_error();
    @data=pool_fetch_row($sth);
    ($chksum)=@data;
    pool_free_result($sth);
    if ($chksum <= 0 && $chksum ne "") {
      $sqlstr="insert into $_oracle_payment_user.check_atm_uwccb (channel_src,atm_main_date,uwccb_baccno,uwccb_tx_date,uwccb_tx_seqno,uwccb_tx_idno,uwccb_space,uwccb_chno,uwccb_dc,uwccb_sign,uwccb_amount,uwccb_bsign,uwccb_bamount,uwccb_memo1,uwccb_tx_mach,uwccb_tx_spec,uwccb_bankid,uwccb_accname,uwccb_memo2,uwccb_tx_time,payment_ins_dt)
               values ('$my_ec_src','$chg_tx_date','$uwccb_baccno','$uwccb_tx_date','$uwccb_tx_seqno','$uwccb_tx_idno','$uwccb_space','$uwccb_chno','$uwccb_dc','$uwccb_sign','$uwccb_amount','$uwccb_bsign','$uwccb_bamount','$uwccb_memo1','$uwccb_tx_mach','$uwccb_tx_spec','$uwccb_bankid','$uwccb_accname','$uwccb_memo2','$uwccb_tx_time',TO_CHAR(sysdate,'YYYY/MM/DD HH24:MI:SS'))";
      #print $sqlstr."\n\n";
      $sth=opool_query($sqlstr,$poolh) or query_error();
      ++$runm;
    }
  }    
  close (FILEHD);

  return $runm;
}
