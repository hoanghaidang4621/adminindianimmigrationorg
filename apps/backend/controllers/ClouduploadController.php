<?php

namespace Indianimmigrationorg\Backend\Controllers;
use Indianimmigrationorg\Repositories\Formatname;

define('MyS3UploadFolder', 'uploads');
class CloudUploadController extends ControllerBase
{
	public function indexAction()
	{
		$uploadFiles = array();
		// Check if the user has uploaded files
        if ($this->request->hasFiles() == true)
		{
            \S3::setAuth(MyS3Key, MyS3Secret);
            $message = array(
				"type" => "error",
				"message" => ""
			);
			$numberOfSuccess = 0;
			$numberOfFail = 0;
			$numberOfFiles = 0;
			$bucket = MyS3Bucket;
            //Upload files
            foreach ($this->request->getUploadedFiles() as $file)
			{
				$numberOfFiles++;
                $path_parts = pathinfo($file->getName());
                $file_extension = strtolower($path_parts['extension']);
                $convertfileName = str_replace('--', '-', Formatname::convertkeyword(Formatname::stripunicode($path_parts['filename'])));
                $fileName = $convertfileName . '-' . time() . '.' . $file_extension;
                $tmp = $file->getTempName();
                $key = MyS3UploadFolder. '/'.$fileName;
                $params = array('Cache-Control' => 'max-age=86400');
                if(isset($this->globalVariable->contentTypeImages[$file_extension])){
                    $params['Content-Type'] = $this->globalVariable->contentTypeImages[$file_extension];
                }
                $result = \S3::putObjectFile($tmp, $bucket , $key, \S3::ACL_PUBLIC_READ,array(),$params);
                if($result) {
                    $uploadFiles[] = array(
                        "file_name" => $fileName,
                        "file_size" => $file->getSize(),
                        "file_type" => $file_extension,
                        "file_type_info" => $file_extension,
                        "file_url" => MyCloudFrontURL . $key
                    );
                    $numberOfSuccess++;
                }
			}
			if($numberOfSuccess==$numberOfFiles)
			{
				$message = array(
					"type" => "success",
					"message" => "All files are uploaded successfully!<br>".$message["message"]
				);
			}
			else
			{
				if($numberOfSuccess>=$numberOfFail)
				{
					$message["type"] = "info";
				}
				else
				{
					$message["type"] = "error";
				}
			}
			$this->view->message = $message;
        }
		$this->view->uploadFiles = $uploadFiles;
	}
}