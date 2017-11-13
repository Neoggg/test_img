############################################  �������� �]�w��  ############################################
###  DB�ѼƳ]�w  ###
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
###  ���O�ѼƳ]�w  ###
$_java_prg="/usr/bin/java";
$_mv_prg="/usr/bin/mv";
$_gzip_prg="/usr/bin/gzip";


###  �ؿ��ѼƳ]�w  ###
$_atmlog_path=$webuserhome."/pec_payment/log-regular/auth_atm_log/";  # ATM���vLOG(file)
$_crdlog_path=$webuserhome."/pec_payment/log-regular/auth_crd_log/";  # �H�Υd���vLOG(file)
$_divlog_path=$webuserhome."/pec_payment/log-regular/auth_div_log/";  # �H�Υd����/���Q�����vLOG(file)
$_settle_log_path=$webuserhome."/pec_payment/log-regular/settle/";    # �д�log�ؿ�
$_chkatm_log_path=$webuserhome."/pec_payment/log-regular/check_atm_log/";  # ATM�ֱblog�ؿ�
$_write_db_errlog_fn=$webuserhome."/pec_payment/log-regular/common/write_db_err_perl.log";  # �gDB��error log


###  ATM�����b��/webATM �ѼƳ]�w �}�l  ###
# ����@�� PEC #
$_uwccb_facid_16{ATMNO}{PEC}="2220";           # ATM�����b�� - 16�X���t�ӥN�X
$_uwccb_cust_id{ATMNO}{PEC}="010120006002";    # ATM�����b�� - webATM ���~/�ө��N�X
$_uwccb_facid_16{WEBATM}{PEC}=$_uwccb_facid_16{ATMNO}{PEC};      # webATM - 16�X���t�ӥN�X (�PATM�����b���@��)
$_uwccb_cust_id{WEBATM}{PEC}=$_uwccb_cust_id{ATMNO}{PEC};        # webATM - webATM ���~/�ө��N�X (�PATM�����b���@��)
$_uwccb_real_account{PEC}="001031002008";      # PEC����b��
#$_uwccb_chkatm_url{PEC}="https://www.myb2b.com.tw/securities/tx10d0_txt.asp";
$_uwccb_chkatm_url{PEC}="https://www.globalmyb2b.com/securities/tx10d0_txt.aspx";
# ����@�� PEC �ֱb: https://www.myb2b.com.tw/securities/tx10d0_txt.asp?cust_id=166061020106&cust_pwd=st3051&cust_nickname=st3052&acno=001031002008&from_date=2008/07/15&to_Date=2008/07/16&from_time=000000&to_time=235959&xml=n&txdate8=Y

# �x�s�Ȧ� PEC #
$_tsb_facid_16{ATMNO}{PEC}="8410";                 # ATM�����b�� - 16�X���t�ӥN�X
$_tsb_cust_id{ATMNO}{PEC}="PCHOME02_TSBeATMGP";    # ATM�����b�� - webATM ���~�N�X
$_tsb_facid_16{WEBATM}{PEC}=$_tsb_facid_16{ATMNO}{PEC};        # webATM - 16�X���t�ӥN�X (�PATM�����b���@��)
$_tsb_cust_id{WEBATM}{PEC}=$_tsb_cust_id{ATMNO}{PEC};          # webATM - webATM ���~�N�X (�PATM�����b���@��)
$_tsb_real_account{PEC}="20680100060032";          # PEC����b��
$_tsb_ftp_file{PEC}=$webuserhome."/pec_payment/proftp/tsb_chkatm/";  # �x�s�Ȧ�FTP�W�Ǫ��ֱb��
# �x�s�Ȧ�AP2AP PEC : https://www.b2bank.com.tw/tbnotice/tbnoticeap2ap1.jsp?vabid=166061020001&optid=stock&tsbcode=08410&datebgn=20080910&url=javascript:return;&password=F5C578E082022E69B6E94075BF9DAB6C
###  ATM�����b��/webATM �ѼƳ]�w ����  ###


##################  NCCC ���v/�д�/�h�� �ѼƳ]�w �}�l  ##################
# NCCC ����]�w�� #
$_nccc_setURL_DomainName='nccnet-ec.nccc.com.tw';      # �]�w NCCC �s�u Domain Name
$_nccc_setURL_RequestURL='/merchant/APIRequest';       # �]�w NCCC �s�u Request URL
$_nccc_setDebug=0;                                     # NCCC debug�T�� 1:�} 0:��
$_nccc_settle_URL='nccnet-ec.nccc.com.tw';             # �]�w NCCC �аh�� Domain Name
$_nccc_up_dn_path=$webuserhome."/pec_payment/include/nccc_lib/";  # ���� NCCC �д��ɪ���m

# NCCC PEC #
$_nccc_trans_model_hash{PEC}='E';                      # S:�l���S���[�c  E:�D�l���S���[�c
$_nccc_merchantid_hash{PEC}='0100802693';              # �S���N�� , �Y���l���S���[�c �h�������S���N��
$_nccc_terminalid_hash{PEC}='70501479';                # �ݥ����N�� , �Y���l���S���[�c �h�������ݥ����N��
$_run_nccc_settle_hash{PEC}=1;                         # �O�_����C��аh�ڵ{��
##################  NCCC ���v/�д�/�h�� �ѼƳ]�w ����  ##################

return 1;
