############################################  正式環境 設定檔  ############################################
###  DB參數設定  ###
$_oracle_payment_pool_big5="mech.pec-1:11245";  # payment oracle
$_oracle_payment_pool_utf8="mech.pec-1:11248";
$_oracle_payment_user="pecpayment";
$_pool_charset="big5";      # big5 or utf8
$_payment_host="pec_payment1-1";
$_crd_port="5269";
$_div_port="6091";
$_atm_port="7153";
$_ezpay_port="8360";

#aa
###  指令參數設定  ###
$_java_prg="/usr/bin/java";
$_mv_prg="/usr/bin/mv";
$_gzip_prg="/usr/bin/gzip";


###  目錄參數設定  ###
$_atmlog_path=$webuserhome."/pec_payment/log-regular/auth_atm_log/";  # ATM授權LOG(file)
$_crdlog_path=$webuserhome."/pec_payment/log-regular/auth_crd_log/";  # 信用卡授權LOG(file)
$_divlog_path=$webuserhome."/pec_payment/log-regular/auth_div_log/";  # 信用卡分期/紅利折抵授權LOG(file)
$_settle_log_path=$webuserhome."/pec_payment/log-regular/settle/";    # 請款log目錄
$_chkatm_log_path=$webuserhome."/pec_payment/log-regular/check_atm_log/";  # ATM核帳log目錄
$_write_db_errlog_fn=$webuserhome."/pec_payment/log-regular/common/write_db_err_perl.log";  # 寫DB的error log


###  ATM虛擬帳號/webATM 參數設定 開始  ###
# 國泰世華 PEC #
$_uwccb_facid_16{ATMNO}{PEC}="2220";           # ATM虛擬帳號 - 16碼的廠商代碼
$_uwccb_cust_id{ATMNO}{PEC}="010120006002";    # ATM虛擬帳號 - webATM 企業/商店代碼
$_uwccb_facid_16{WEBATM}{PEC}=$_uwccb_facid_16{ATMNO}{PEC};      # webATM - 16碼的廠商代碼 (與ATM虛擬帳號共用)
$_uwccb_cust_id{WEBATM}{PEC}=$_uwccb_cust_id{ATMNO}{PEC};        # webATM - webATM 企業/商店代碼 (與ATM虛擬帳號共用)
$_uwccb_real_account{PEC}="001031002008";      # PEC實體帳戶
#$_uwccb_chkatm_url{PEC}="https://www.myb2b.com.tw/securities/tx10d0_txt.asp";
$_uwccb_chkatm_url{PEC}="https://www.globalmyb2b.com/securities/tx10d0_txt.aspx";
# 國泰世華 PEC 核帳: https://www.myb2b.com.tw/securities/tx10d0_txt.asp?cust_id=166061020106&cust_pwd=st3051&cust_nickname=st3052&acno=001031002008&from_date=2008/07/15&to_Date=2008/07/16&from_time=000000&to_time=235959&xml=n&txdate8=Y

# 台新銀行 PEC #
$_tsb_facid_16{ATMNO}{PEC}="8410";                 # ATM虛擬帳號 - 16碼的廠商代碼
$_tsb_cust_id{ATMNO}{PEC}="PCHOME02_TSBeATMGP";    # ATM虛擬帳號 - webATM 企業代碼
$_tsb_facid_16{WEBATM}{PEC}=$_tsb_facid_16{ATMNO}{PEC};        # webATM - 16碼的廠商代碼 (與ATM虛擬帳號共用)
$_tsb_cust_id{WEBATM}{PEC}=$_tsb_cust_id{ATMNO}{PEC};          # webATM - webATM 企業代碼 (與ATM虛擬帳號共用)
$_tsb_real_account{PEC}="20680100060032";          # PEC實體帳戶
$_tsb_ftp_file{PEC}=$webuserhome."/pec_payment/proftp/tsb_chkatm/";  # 台新銀行FTP上傳的核帳檔
# 台新銀行AP2AP PEC : https://www.b2bank.com.tw/tbnotice/tbnoticeap2ap1.jsp?vabid=166061020001&optid=stock&tsbcode=08410&datebgn=20080910&url=javascript:return;&password=F5C578E082022E69B6E94075BF9DAB6C
###  ATM虛擬帳號/webATM 參數設定 結束  ###


##################  NCCC 授權/請款/退款 參數設定 開始  ##################
# NCCC 全域設定值 #
$_nccc_setURL_DomainName='nccnet-ec.nccc.com.tw';      # 設定 NCCC 連線 Domain Name
$_nccc_setURL_RequestURL='/merchant/APIRequest';       # 設定 NCCC 連線 Request URL
$_nccc_setDebug=0;                                     # NCCC debug訊息 1:開 0:關
$_nccc_settle_URL='nccnet-ec.nccc.com.tw';             # 設定 NCCC 請退款 Domain Name
$_nccc_up_dn_path=$webuserhome."/pec_payment/include/nccc_lib/";  # 產生 NCCC 請款檔的位置

# NCCC PEC #
$_nccc_trans_model_hash{PEC}='E';                      # S:子母特店架構  E:非子母特店架構
$_nccc_merchantid_hash{PEC}='0100802693';              # 特店代號 , 若為子母特店架構 則為母店特店代號
$_nccc_terminalid_hash{PEC}='70501479';                # 端末機代號 , 若為子母特店架構 則為母店端末機代號
$_run_nccc_settle_hash{PEC}=1;                         # 是否執行每日請退款程序
##################  NCCC 授權/請款/退款 參數設定 結束  ##################

return 1;
