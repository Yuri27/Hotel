<?session_start();
class TLogger {

public $fLogPath;
public $fLogLevel;

public $list_error=[
	1 => "Ошибка подключения к БД",
	2 => "Критическая ОШИБКА!!!",
	3 => "Файл не найден",
	4 => "Ошибка открытия",
	5 => "Время ожидания истекло",
	6 => "Неверный логин или пароль",
	7 => "Исчерпано количество попыток ввода пароля",
	8 => "Сервер недоступен",
	9 => "Авторизован администратор на сайте",
	10 => "Авторизован пользователь",
	11 => "База данных уже создана",
	12 => "Введено данные для подключения",
	13 => "Подключено к серверу",
];

public function __construct(/*$name, $file=null*/) 
	{
		include 'LoggerIni.php';
		$this->fLogPath = $loggerPath ;
		$this->fLogLevel = $loggerLevel;
 		// echo $this->fLogLevel.$this->fLogPath;
   //      echo '<br>'."Вызываем";
		// заинклудить конфиг
		// прочитать в приватовские поля значения конфига 
	
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
			//записать в файл
			$this->writeLog($aText,$aPath);
		}
	}
	
private function writeLog($aText,$aPath/*, $aLevel = NULL, $aPath*/)
	{
		$path = 'C:\OpenServer\domains\radisson.ua\logger\\';

		// Если нет счетчика, создаем:
 		if(!file_exists($path."logs_count.txt"))
		{
			$fp = fopen($path."logs_count.txt", "w");
			fwrite($fp, "0");
			fclose($fp);
		}

		// Открываем счетчик
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