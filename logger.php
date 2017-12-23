<?session_start();
class TLogger {

public $fLogPath;
public $fLogLevel;

public $list_error=[
	1 => "������ ����������� � ��",
	2 => "����������� ������!!!",
	3 => "���� �� ������",
	4 => "������ ��������",
	5 => "����� �������� �������",
	6 => "�������� ����� ��� ������",
	7 => "��������� ���������� ������� ����� ������",
	8 => "������ ����������",
	9 => "����������� ������������� �� �����",
	10 => "����������� ������������",
	11 => "���� ������ ��� �������",
	12 => "������� ������ ��� �����������",
	13 => "���������� � �������",
];

public function __construct(/*$name, $file=null*/) 
	{
		include 'LoggerIni.php';
		$this->fLogPath = $loggerPath ;
		$this->fLogLevel = $loggerLevel;
 		// echo $this->fLogLevel.$this->fLogPath;
   //      echo '<br>'."��������";
		// ����������� ������
		// ��������� � ������������ ���� �������� ������� 
	
	}

public function write($aText, $aPath = NULL, $aLevel = NULL)
	{
		if ($aLevel==NULL)
			{
				$aLevel=$this->fLogLevel;
			}
		if($aPath==NULL)
			{
				$aPath=$this->fLogPath;
			}
		if($aLevel>($this->fLogLevel)){
			return 1;
		}
		else{	
			//�������� � ����
			$this->writeLog($aText,$aPath);
		}
	}
	
private function writeLog($aText,$aPath/*, $aLevel = NULL, $aPath*/)
	{
		$path = 'C:\OpenServer\domains\radisson.ua\logger\\';

		// ���� ��� ��������, �������:
 		if(!file_exists($path."logs_count.txt"))
		{
			$fp = fopen($path."logs_count.txt", "w");
			fwrite($fp, "0");
			fclose($fp);
		}

		// ��������� �������
		$increment = file_get_contents($path."logs_count.txt");

		$filesize = filesize($path."$aPath".($increment).".log");
		if($filesize>90){
			$increment = intval($increment) + 1;
    		$fp = fopen($path."logs_count.txt", "w");
			fwrite($fp, $increment);
			fclose($fp); 
			
		}			
		// echo "<br>filesize ".($increment)."=".$filesize;

		$fp = fopen($path."$aPath".($increment).".log", "a");
		$setting=date("[d/m/Y H:i:s]").$aText."\r\n";
		fwrite($fp, $setting);
		fclose($fp);
			
		if($increment>=10)
		{	
			if(file_exists($path."$aPath".($increment-10).".log"))
			{	
				unlink($path."$aPath".($increment-10).".log");
				echo "<br>unlink";
				}
			else{
				return 1;
			}
		}
	}
}
$log=new TLogger();

?>