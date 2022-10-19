<?php
/**
 * My
 *
 * My Common functions
 */
class My extends Phalcon\Mvc\User\Component
{

    public function localTime($time)
    {
        return (int)$time + $this->globalVariable->timeZone;
    }

    //convert local site time to UTC0
    public function UTCTime($time)
    {
        return (int)$time - (int)$this->globalVariable->timeZone;
    }

    function formatDateTime($time)
    {
        return strftime('%b/%d/%Y %H:%M:%S', $this->localTime($time));
    }
    function formatTime($time)
    {
        return strftime('%m/%d/%Y %H:%M', $this->localTime($time));
    }
    //send email
    public function sendEmail($fromEmail, $toEmail, $subject, $message, $fromFullName, $toFullName, $reply_to_email, $reply_to_name)
    {
        if (defined('EMAIL_TEST_MODE') && EMAIL_TEST_MODE && defined('EMAIL_TEST_EMAIL')) {
            $toEmail = EMAIL_TEST_EMAIL;
        }
        /** @var \PHPMailer $mail */
        $mail = $this->myMailer;
        if (!$mail) return array('success' => false, 'message' => 'Mail is null!');
        $result = array();
        try {
            //reply to
            $mail->AddReplyTo($reply_to_email, $reply_to_name);
            //
            $mail->SetFrom($fromEmail, '=?utf-8?B?'.base64_encode($fromFullName).'?='); //from (verified email address)
            $mail->Subject = '=?utf-8?B?'.base64_encode((defined('EMAIL_SUBJECT_PREFIX') ? EMAIL_SUBJECT_PREFIX : '') . $subject).'?='; //subject
            //message
            $body = $message;
            //$body = preg_replace("/\\/i",'',$body);
            $mail->MsgHTML($body);
            //
            //recipient
            $mail->AddAddress($toEmail, $toFullName);

            // add bbc
            //$mail->AddBCC($bbc_email, $bbc_name);
            //Success
            $isSent = $mail->Send();
            if ($isSent) {
                $result['success'] = true;
                $result['message'] = "Message sent!";
            }
            else
            {
                $result['success'] = false;
                $result['message'] = "Mailer Error: " . $mail->ErrorInfo;
            }
        } catch (phpmailerException $e) {
            $result['success'] = false;
            $result['message'] = "Mailer Error: " . $e->errorMessage();//Pretty error messages from PHPMailer
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = "Mailer Error: " . $e->getMessage();//Boring error messages from anything else!
        }
        $mail->ClearAllRecipients();
        $mail->ClearReplyTos();
        $mail->ClearAttachments();
        return $result;
    }

    public function renderPagination($url, $page, $totalPages, $limit = 0, $attributes = array())
    {
        if ($page < 1) $page = 1;
        if ($totalPages < 1) $totalPages = 1;

        $disablePrevious = $page <= 1;
        $disableNext = $page >= $totalPages;
        $showLeftDot = ($limit != 0) && ($page - $limit > 2);
        $showRightDot = ($limit != 0) && ($page + $limit < $totalPages - 1);
        $showFirstPage = ($limit != 0) && ($page - $limit >= 2);
        $showLastPage = ($limit != 0) && ($page + $limit <= $totalPages - 1);

        $attributeString = '';
        foreach ($attributes as $key => $value) {
            $key = strtolower(trim((string)$key));
            if ($key != 'class') {
                $attributeString .= $key . '="' . $value . ' ';
            }
        }

        $html = '<ul class="pagination end ' . (isset($attributes['class']) ? $attributes['class'] : '') . '" ' . $attributeString . '>';

        if ($disablePrevious) {
            $html .= '<li class="disabled"><span class="item">&laquo;</span></li>';
            $html .= '<li class="disabled"><span class="item">Previous</span></li>';
        } else {
            $html .= '<li><a class="item" href="' . $url . (1) . '" >&laquo;</a></li>';
            $html .= '<li><a class="item" href="' . $url . ($page - 1) . '" >Previous</a></li>';
        }

        if ($limit == 0) {
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($page == $i) {
                    $html .= '<li class="active"><span class="item">' . $i . '</span></li>';
                } else {
                    $html .= '<li><a class="item" href="' . $url . $i . '" >' . $i . '</a></li>';
                }
            }
        } else {
            if ($showFirstPage) $html .= '<li><a class="item" href="' . $url . (1) . '" >1</a></li>';
            if ($showLeftDot) $html .= '<li><a class="item">&hellip;</a></li>';
            for ($i = $page - $limit; $i <= $page + $limit; $i++) {
                if ($i < 1 || $i > $totalPages) continue;
                if ($page == $i) {
                    $html .= '<li class="active"><span class="item">' . $i . '</span></li>';
                } else {
                    $html .= '<li><a class="item" href="' . $url . $i . '" >' . $i . '</a></li>';
                }
            }
            if ($showRightDot) $html .= '<li><a class="item">&hellip;</a></li>';
            if ($showLastPage) $html .= '<li><a class="item" href="' . $url . $totalPages . '" >' . $totalPages . '</a></li>';
        }

        if ($disableNext) {
            $html .= '<li class="disabled"><span class="item">Next</span></li>';
            $html .= '<li class="disabled"><span class="item">&raquo;</span></li>';
        } else {
            $html .= '<li><a class="item" href="' . $url . ($page + 1) . '" >Next</a></li>';
            $html .= '<li><a class="item" href="' . $url . ($totalPages) . '" >&raquo;</a></li>';
        }

        $html .= '</ul>';
        return $html;
    }
    public function sendError($message,$title)
    {
        if (defined('EMAIL_TEST_MODE') && EMAIL_TEST_MODE && defined('EMAIL_TEST_EMAIL')) {
            $toEmail = EMAIL_TEST_EMAIL;
        }else{
            $toEmail = 'dev-error@bin.com.vn';
        }
        /** @var \PHPMailer $mail */
        $mail = $this->myMailer;
        if (!$mail) return array('success' => false, 'message' => 'Mail is null!');
        //reply to
        $mail->AddReplyTo("noreply@bin.vn", "Noreply Sender");
        $mail->SetFrom("noreply@bin.vn", "BIN Media System Error");
        //get date
        $date_now = date("Y-m-d H:i:s");
        $mail->Subject = (defined('EMAIL_SUBJECT_PREFIX') ? EMAIL_SUBJECT_PREFIX : '') . "System BIN Media Error - " ."[".$date_now."]" . " - " . $title; //subject
        //message
        $body = $message;
        //$body = eregi_replace("[\]",'',$body);
        $mail->MsgHTML($body);
        //
        //recipient
        $whitelist = array('127.0.0.1', "::1");
        if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            $mail->AddAddress($toEmail, "BIN Media System Error");
        }
        // add bbc
        //$mail->AddBCC($bbc_email, $bbc_name);
        //Success
        $isSent = $mail->Send();
        $result = array();
        if ($isSent) {
            $result['success'] = true;
            $result['message'] = "Message sent!";
        }
        //Error
        if(!$isSent) {
            $result['success'] = false;
            $result['message'] = "Mailer Error: " . $mail->ErrorInfo;
        }
        $mail->ClearAllRecipients();
        $mail->ClearReplyTos();
        $mail->ClearAttachments();
        return $result;
    }
    public function sendErrorEmailAndRedirectToNotFoundPage()
    {
        $sent_error = new \Indianimmigrationorg\Repositories\SendError();
        $sent_error->sendErrorNotfound('');
        $this->response->redirect('/notfound');
    }

    function getComboBox($array, $value = '')
    {
        $string="";
        foreach ($array as $key => $item){
            $selected ="";
            if($key == $value){
                $selected ="selected='selected'";
            }
            $string.="<option ".$selected."  value='".$key."'>".$item."</option>";
        }
        return $string;
    }
    function getIdFromFormatID($formattedId, $hasSub = false)
    {
        if (intval($formattedId) != 0) {
            if ($hasSub && strlen($formattedId) > 6)
                return intval(substr($formattedId, 3));
            else if (strlen($formattedId) > 5)
                return intval(substr($formattedId, 2));
        }
        return $formattedId;
    }
    public function formatID($idType, $insertTime, $id, $suffix='')
    {
        $insertYear = date('Y', $insertTime);
        $y = substr($insertYear, strlen($insertYear)-1);
        return sprintf("%s%s%04d%s",$idType,$y,$id,$suffix);
    }
    public function formatSubID($idType, $insertTime, $id, $options)
    {
        $insertYear = date('Y', $insertTime);
        $y = substr($insertYear, strlen($insertYear) - 1);
        return "8" . sprintf("%s%s%s%04d%s", $idType, $y, $options['subType'], $id, $options['suffix']); //8 is site number
    }
    public function formatUserID($insertTime, $id)
    {
        return $this->formatID(1, $insertTime, $id);
    }
    public function formatOrderID($insertTime, $id)
    {
        return $this->formatID(2, $this->localTime($insertTime), $id);
    }
    public function formatCheckStatusID($insertTime, $id)
    {
        return $this->formatID(3, $this->localTime($insertTime), $id);
    }
    public function formatContactID($insertTime, $id)
    {
        return $this->formatID(4, $this->localTime($insertTime), $id);
    }
    public function formatLeadformID($insertTime, $id)
    {
        return $this->formatID(5, $this->localTime($insertTime), $id);
    }
    public function formatReceiptID($insertTime, $id, $n)
    {
        return $this->formatSubID(6, $insertTime, $id, array("subType" => "", "suffix" => "_" . $n));
    }
    public function formatPaymentID($insertTime, $id)
    {
        return $this->formatID(7, $insertTime, $id);
    }

    //format USD
    public function formatUSD($number)
    {
        return number_format($number, 2, '.', ',');
    }
    public function getMethod($method, $cardType, $isenrolled3d, $ispassed3d, $dashboard = false)
    {
        $_method = $method;
        if (!$dashboard) {
            if (
                $method == "Credit/Debit Card" || $method == "Credit/Debit Card (Stripe)"
                || $method == "Credit/Debit Card (CyberSource)"
                || $method == "Credit/Debit Card (Paypal)"
                || $method == "Credit/Debit Card (Amex)"
            )
                $_method = "Credit or Debit Card";
            else if ($method == "Credit/Debit Card (2C2P)") {
                $_method = "Credit Card (processed by 2C2P)";
            }
        }
        if ($cardType) {
            $_method .= " - " . $cardType;
        }

        if ($method != "Credit/Debit Card (2C2P)")
            if ($isenrolled3d == 'Y' || $isenrolled3d == 'Y') {
                if ($ispassed3d  == 'Y' || $ispassed3d  == 'Y') {
                    $_method .= '<br/>(Passed 3D Secure)';
                } else {
                    $_method .= '<br/>(Failed 3D Secure)';
                }
            } else if ($isenrolled3d == 'N') {
                $_method .= '<br/>(None 3D Secure)';
            }
        return $_method;
    }
    function formatDateDMY($time)
    {
        return date('d-m-Y', $time);
    }
    function formatDateYMD($time)
    {
        return date('Y-m-d', $time);
    }
    function getHrefLastValue($value = '')
    {
        $find = explode("/", $value);
        return end($find);
    }
    public function getPdfInvoiceName($idFormatted, $insert_time)
    {
        return "Invoice_Order_" . $idFormatted . "_" . $insert_time . ".pdf";
    }
    public function getPdfReceiptName($idFormatted, $insert_time)
    {
        return "Receipt_Order_" . $idFormatted . "_" . $insert_time . ".pdf";
    }
    public function getPdfInvoicePaymentName($idFormatted, $insert_time)
    {
        return "Invoice_Payment_" . $idFormatted . "_" . $insert_time . ".pdf";
    }
    public function getPdfReceiptPaymentName($idFormatted, $insert_time)
    {
        return "Receipt_Payment_" . $idFormatted . "_" . $insert_time . ".pdf";
    }

}

