<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 0); 
ini_set('memory_limit', '-1');
class Telephony extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('excel');
	}

	public function index()
	{
		$this->load->view('telephony/index');
	}

	public function telephonyTrunk()
	{
		$getDateApply = ($_GET['getDateApply']) ? $_GET['getDateApply'] : NULL ;
		$getFromTime = ($_GET['getFromTime']) ? $_GET['getFromTime'] : '0000' ;
		$getToTime = ($_GET['getToTime']) ? $_GET['getToTime'] : '2359' ;
$getText ='\'LANGUAGE=ENU
\'SERVERNAME=xx.xx.xx.xx 
Public Sub Main()

';
$getText .='\'## cvs_cmd_begin
';
$getText .='\'## ID = 2001
';
$getText .='\'## Description = "Report: Historical: Designer: Call Records: Export Data"
';
$getText .='\'## Parameters.Add "Report: Historical: Designer: Call Records: Export Data","_Desc"
';
$getText .='\'## Parameters.Add "Reports","_Catalog"
';
$getText .='\'## Parameters.Add "2","_Action"
';
$getText .='\'## Parameters.Add "1","_Quit"
';
$getText .='\'## Parameters.Add "Historical\Designer\Call Records","_Report"
';
$getText .='\'## Parameters.Add "1","_ACD"
';
$getText .='\'## Parameters.Add "180","_Top"
';
$getText .='\'## Parameters.Add "1305","_Left"
';
$getText .='\'## Parameters.Add "17880","_Width"
';
$getText .='\'## Parameters.Add "11160","_Height"
';
$getText .='\'## Parameters.Add "default","_TimeZone"
';
$getText .='\'## Parameters.Add "The report Historical\Designer\Call Records was not found on ACD 1.","_ReportNotFound"
';
$getText .='\'## Parameters.Add "*","_BeginProperties"
';
$getText .='\'## Parameters.Add "'.$getDateApply.'","Start Date"
';
$getText .='\'## Parameters.Add "'.$getFromTime.'","Start Time"
';
$getText .='\'## Parameters.Add "'.$getDateApply.'","Stop Date"
';
$getText .='\'## Parameters.Add "'.$getToTime.'","Stop Time"
';
$getText .='\'## Parameters.Add "*","_EndProperties"
';
$getText .='\'## Parameters.Add "*","_BeginViews"
';
$getText .='\'## Parameters.Add "*","_EndViews"
';
$getText .='\'## Parameters.Add "C:\\xampp\htdocs\REPORTING_SYSTEM\uploads\call-records.xls","_Output"
';
$getText .='\'## Parameters.Add "59","_FldSep"
';
$getText .='\'## Parameters.Add "0","_TextDelim"
';
$getText .='\'## Parameters.Add "True","_NullToZero"
';
$getText .='\'## Parameters.Add "True","_Labels"
';
$getText .='\'## Parameters.Add "True","_DurSecs"
';
$getText .='
   On Error Resume Next

   cvsSrv.Reports.ACD = 1
   Set Info = cvsSrv.Reports.Reports("Historical\Designer\Call Records")

   If Info Is Nothing Then
	  If cvsSrv.Interactive Then
		  MsgBox "The report Historical\Designer\Call Records was not found on ACD 1.", vbCritical Or vbOKOnly, "Avaya CMS Supervisor"
	  Else
	   	  Set Log = CreateObject("ACSERR.cvsLog") 
		  Log.AutoLogWrite "The report Historical\Designer\Call Records was not found on ACD 1."
		  Set Log = Nothing
	  End If
   Else

	   b = cvsSrv.Reports.CreateReport(Info,Rep)
	   If b Then
	
	      Rep.Window.Top = 180
	      Rep.Window.Left = 1305
	      Rep.Window.Width = 17880
	      Rep.Window.Height = 11160        
	

                        Rep.TimeZone = "default"


	
	      Rep.SetProperty "Start Date","'.$getDateApply.'"
	
	      Rep.SetProperty "Start Time","'.$getFromTime.'"
	
	      Rep.SetProperty "Stop Date","'.$getDateApply.'"
	
	      Rep.SetProperty "Stop Time","'.$getToTime.'"
	
	
	

	      b = Rep.ExportData("C:\\xampp\htdocs\REPORTING_SYSTEM\uploads\call-records.xls", 59, 0, True, True, True)

	

	

	      Rep.Quit

	

              If Not cvsSrv.Interactive Then cvsSrv.ActiveTasks.Remove Rep.TaskID
	      Set Rep = Nothing
	   End If

   End If
   Set Info = Nothing';
$getText .='\'## cvs_cmd_end


';
$getText .='End Sub
';
	
	$fp = fopen("C:\\xampp\\htdocs\\REPORTING_SYSTEM\\uploads\\file_excel_trunk.acsauto","wb");
		fwrite($fp,$getText);
    	$success = fclose($fp);
    	if ($success) {
 $getText2 ='
C:\\xampp\\htdocs\\REPORTING_SYSTEM\\uploads\\file_excel_trunk.acsauto /s

exit
';
		$fp2 = fopen("C:\\xampp\\htdocs\\REPORTING_SYSTEM\\uploads\\file_excel_trunk.bat","wb");
		fwrite($fp2,$getText2);
    	$success2 = fclose($fp2);
    	if ($success2) {
    		$dataexcecutes = exec("cmd cd /c C:\\xampp\\htdocs\\REPORTING_SYSTEM\\uploads\\file_excel_trunk.bat /s");
			if ($dataexcecutes) {
				$fileRecord="C:\\xampp\\htdocs\\REPORTING_SYSTEM\\uploads\\call-records.xls";
				$searchSheets="C:\\xampp\\htdocs\\REPORTING_SYSTEM\\uploads\\SearchProject.xls";
				$objPHPExcel = PHPExcel_IOFactory::load($fileRecord);
				$objExSheets = PHPExcel_IOFactory::load($searchSheets);

				$getArrAtts = array();
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				    $worksheetTitle     = $worksheet->getTitle();
				    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
				    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				    $nrColumns = ord($highestColumn) - 64;
				    $total_rows = $highestRow-1;
				    $dataArr = array();
				    for ($row = 4; $row <= $highestRow; ++ $row) {
				        $cell = $worksheet->getCellByColumnAndRow(0,$row);
				        $recordCols = explode(';', $cell);
				        $dataArr['Call_ID'] = $recordCols[0];
				        $dataArr['Segment'] = $recordCols[1];
				        $dataArr['Date'] = $recordCols[2];
				        $dataArr['Start_Time'] = $recordCols[3];
				        $dataArr['Calling_Party'] = $recordCols[4];
				        $dataArr['Dialed_Number'] = $recordCols[5];
				        $dataArr['Disposition'] = $recordCols[6];
				        $dataArr['Disposition_Time'] = $recordCols[7];
				        $dataArr['Split_Skill'] = $recordCols[8];
				        $dataArr['Ans_Logid'] = $recordCols[9];
				        $dataArr['Rls'] = $recordCols[10];
				        $dataArr['Talk_Time'] = $recordCols[11];
				        $dataArr['Hold_Time'] = $recordCols[12];
				        $dataArr['ACW_Time'] = $recordCols[13];
				        $dataArr['Trans_Out'] = $recordCols[14];
				        $dataArr['Conf'] = $recordCols[15];
				        $dataArr['Assist'] = $recordCols[16];
				        $dataArr['Last_Call_Work_Code'] = $recordCols[17];
				        	$getArrAtts[] = $dataArr;
				    }
				}
				// print_r($getArrAtts);


				

				$objPHPExcel = new PHPExcel();
				$exSheetTitle = "";
				foreach($objExSheets->getAllSheets() as $newSheet) {
				    $objPHPExcel->addExternalSheet($newSheet);
				    $exSheetTitle    = $worksheet->getTitle();

				}
				$objPHPExcel->getActiveSheet()->setTitle('CallRecord');
				$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Call_ID');
				$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Segment');
				$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Date');
				$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Start_Time');
				$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Calling_Party');
				$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Dialed_Number');
				$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Disposition');
				$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Disposition_Time');
				$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Split_Skill');
				$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Ans_Logid');
				$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Rls');
				$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Talk_Time');
				$objPHPExcel->getActiveSheet()->setCellValue('M2', 'Hold_Time');
				$objPHPExcel->getActiveSheet()->setCellValue('N2', 'ACW_Time');
				$objPHPExcel->getActiveSheet()->setCellValue('O2', 'Trans_Out');
				$objPHPExcel->getActiveSheet()->setCellValue('P2', 'Conf');
				$objPHPExcel->getActiveSheet()->setCellValue('Q2', 'Assist');
				$objPHPExcel->getActiveSheet()->setCellValue('R2', 'Last_Call_Work_Code');
				$objPHPExcel->getActiveSheet()->setCellValue('S2', 'Final Search');
				$row = 3;
				foreach ($getArrAtts as $kGetArrAtts => $vGetArrAtts) {
					if (empty($vGetArrAtts['Calling_Party']) || empty($vGetArrAtts['Dialed_Number']) || (strlen($vGetArrAtts['Calling_Party']) <= 6 && strlen($vGetArrAtts['Dialed_Number']) <= 6)) {
						
					} else {
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $vGetArrAtts['Call_ID']);
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $vGetArrAtts['Segment']);
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $vGetArrAtts['Date']);
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $vGetArrAtts['Start_Time']);
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $vGetArrAtts['Calling_Party']);
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $vGetArrAtts['Dialed_Number']);
						$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $vGetArrAtts['Disposition']);
						$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $vGetArrAtts['Disposition_Time']);
						$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $vGetArrAtts['Split_Skill']);
						$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $vGetArrAtts['Ans_Logid']);
						$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $vGetArrAtts['Rls']);
						$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $vGetArrAtts['Talk_Time']);
						$objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $vGetArrAtts['Hold_Time']);
						$objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $vGetArrAtts['ACW_Time']);
						$objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $vGetArrAtts['Trans_Out']);
						$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $vGetArrAtts['Conf']);
						$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $vGetArrAtts['Assist']);
						$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $vGetArrAtts['Last_Call_Work_Code']);
						if (strlen($vGetArrAtts['Calling_Party']) > 6 ) {
							$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '=VLOOKUP(F'.$row.',ProjectList!$A$2:$B$100,2,0)');
						} else {
							$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '=VLOOKUP(I'.$row.',ProjectList!$E$2:$F$100,2,0)');
						}
						$row++;
					}
				}

				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="callRecords('.date("m-d-Y").').xlsx"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
				// $objWriter->setPreCalculateFormulas(FALSE);

		      	$objWriter->save('php://output');
		      	exit();
    		}
		
		}
    }

}

	function copy_file_nmf() {
		$dt_folder = $this->input->post('path_folder');
		$this->load->library('upload');
		
		// Parsing File Excel Into Array

    	$objPHPExcel = PHPExcel_IOFactory::load($_FILES['upload_data']['tmp_name']);
		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$getHighestCol = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
		$HighestcolNums = PHPExcel_Cell::columnIndexFromString($getHighestCol);
		$trueHCols = $HighestcolNums - 2;
		$highestColName = PHPExcel_Cell::stringFromColumnIndex($trueHCols);
		$allrow = count($allDataInSheet);
		$raw_datas = array();
		$count_dups = 0;
		$count_ins = 0;

		// Create Folder For Temporary nmf file to save

		if (!is_dir(APPPATH."../record_zip/".$dt_folder."/voice")) {
			mkdir(APPPATH."../record_zip/".$dt_folder."/voice", 0777, true);
		}
		if ($this->input->post('type_file') > 1) {
			if (!is_dir(APPPATH."../record_zip/".$dt_folder."/video")) {
				mkdir(APPPATH."../record_zip/".$dt_folder."/video", 0777, true);
			}
		}

		$voice_folder = realpath(APPPATH."../record_zip/".$dt_folder."/voice");
		
		if ($this->input->post('type_file') > 1) {
			$video_folder = realpath(APPPATH."../record_zip/".$dt_folder."/video");
		}


		// Define Array File From Excel File 
		$output = array();
		// var_dump($allDataInSheet);
		for ($row=2; $row <= $allrow ; $row++) {

			// $allDataInSheet[$row]['B'] Is Column B From Parsing Excel To Get Date Time And Redefine As Needed

			//GetName Define As Copy File Name
			$getName = explode(' ', $allDataInSheet[$row]['B']);

			// $allDataInSheet[$row]['F'] as define unique number to campare existing file nmf in NICE Server
			$secId = $allDataInSheet[$row]['F'];

			$ndate = explode(' ',$allDataInSheet[$row]['D']);
			$parseDate = explode('/', $ndate[0]);
			$foldernmf =  $parseDate[2]."\\".$parseDate[0]."\\".$parseDate[1];
			$getduration = str_replace(':', '_', str_replace(' ', '_', str_replace('/','-', $allDataInSheet[$row]['C'])))."_to_".str_replace(':', '_', str_replace(' ', '_', str_replace('/','-', $allDataInSheet[$row]['D'])));

			exec('dir /b /s "\\\\xx.xx.xx.xx\\Data_Storage\\JKT-ENGAGE\\47\\'.$foldernmf.'\\SC_jkt-unified\\*'.$secId.'*"', $output);

			if (empty($output)) {
				echo 'No Record Data Found !!!!';
			} else {
				if (!$voice_folder) {
				    die('Failed to create folders...');
				} else {
					$filenames = explode('\\',end($output));
					$filename = end($filenames);
					// echo $vfile.' '.$voice_folder.'\\'.$getName[0].'_'.$getduration.'_'.$secId.'.nmf';
					$getNew = $voice_folder.'\\'.$getName[0].'_'.$getduration.'_'.$secId.'.nmf';
					// exec('xcopy '.$vfile.' '.$dt_folder.'\\voice\\'.$getName[0].'_'.$getduration.'_'.$secId.'.nmf /f');
					if(!copy(end($output), $getNew)) {
						echo "Not Copy";
					} else {
						echo "Success Copy";
					}
					echo "<br/>";
					$getrename = $voice_folder.'\\'.$filename;
					exec('RENAME "'.$getrename.'" '.$getName[0].'_'.$getduration.'_'.$secId, $outrename);
					// echo "</pre>";
				}
			}
			if ($this->input->post('type_file') > 1) {
				exec('dir /b /s "\\\\xx.xx.xx.xx\\JKT-Screen\\JKT-ENGAGE\\47\\'.$foldernmf.'\\SC_jkt-unified\\*'.$secId.'*"', $output2);
				if (empty($output2)) {
					// echo 'No Record Video Found !!!!';
				} else {
					if (!$video_folder) {
					    die('Failed to create folders...');
					} else {
						$filenamesv = explode('\\',end($output2));
						$filenamev = end($filenamesv);

						$getNew2 = $video_folder.'\\'.$getName[0].'_'.$getduration.'_'.$secId.'.nmf';
						if(!copy(end($output2), $getNew2)) {
							echo "Not Copy Video";
						} else {
							echo "Success Copy Video";
						}
						echo "<br/>";
						$getrename2 = $video_folder.'\\'.$filenamev;
						exec('RENAME "'.$getrename2.'" '.$getName[0].'_'.$getduration.'_'.$secId, $outrename2);
					}
				}
			}
		}

		$this->create_zip($dt_folder);
	}

	function create_zip($dt_folder) {
	    $filename_no_ext= APPPATH."../record_zip/".$dt_folder;

		$rootPath = realpath($filename_no_ext);
		$filenames = APPPATH.'../record_zip/record_'.date('Y_m_d_H_i_s').'.zip';
		$zip = new ZipArchive();
		$zip->open($filenames, ZipArchive::CREATE | ZipArchive::OVERWRITE);

		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
		    // Skip directories (they would be added automatically)
		    if (!$file->isDir())
		    {
		        // Get real and relative path for current file
		        $filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);

		        // Add current file to archive
		        $zip->addFile($filePath, $relativePath);
		    }
		}

		// Zip archive will be created only after closing object
		$zip->close();

		$file_url = $filenames;
		header('Content-Type: application/zip');
		// header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
		header("Pragma: no-cache");
		header("Expires: 0");
		readfile($file_url);
		unlink($file_url);
	}

	function create_zip2($dt_folder) {
		$filename_no_ext= APPPATH."../record_zip/".$dt_folder;
		// echo 
		$nama_file = 'record_'.date('Y_m_d_H_i_s');
		$this->load->library('zip');
		$this->zip->read_dir($filename_no_ext);
		$this->zip->archive($filename_no_ext.'/'.$nama_file.'.zip');
		$this->zip->download($nama_file.'.zip');
		// $filename_no_ext
	}	


}

/* End of file Telephony.php */
/* Location: ./application/controllers/Telephony.php */