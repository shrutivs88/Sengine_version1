<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
$data = new DatabaseManager();
$conn = $data->getConnection();
$user_Id=$_POST['userid'];
 $userclient="select user_emp_id from users where user_id=$user_Id";
$resultclient = mysqli_query($conn,$userclient);
$resfetchclient = mysqli_fetch_object($resultclient);
$emap_idclient= $resfetchclient->user_emp_id;
                        
    $client_sqlclient = "select * from client_contacts where assoc_manager_id='$emap_idclient'";
    
    $client_resclient = mysqli_query($conn, $client_sqlclient);
                        
                        
                        //$total = mysqli_num_rows($res);
                        //echo $total;
                           $clientemails=array();
                        while($client_rowclient = mysqli_fetch_object($client_resclient))
                        {
                            $three_set_client_emails_=$client_rowclient->client_contact_email;
                            $client_emails = explode(',',$three_set_client_emails_);
                            array_push($clientemails,$client_emails[0]);
                        }
                            $sql_mail_config="select * from mail_config";
                            $res_mail_config = mysqli_query($conn,$sql_mail_config);
                            $row_mail_config=mysqli_fetch_object($res_mail_config);
                            $host = $row_mail_config->mail_config_host;
                            $username = $row_mail_config->mail_config_user_name;
                            $in = "INBOX";
                            $host_mail='{'.$host.'}'.$in;
                            $password = $row_mail_config->mail_config_password;                                    
                            $inbox = imap_open($host_mail, $username, $password);
                           // $inbox = imap_open("{mail.pnrpoint.com:143/novalidate-cert}INBOX" , "contact@pnrpoint.com", "q12wq12w")  or die('Cannot connect to Gmail: ' . imap_last_error());
                            $emails = imap_search($inbox,'ALL'); 
                            /*$header = imap_header($inbox, $emails);
                          
                                $to = $header->to;
                                foreach ($to as $id => $object) {
                                echo $toname = $object->personal;
                               echo $toaddress = $object->mailbox . "@" . $object->host;
                                }  */
                                
                          //  $max_emails = 16;
                            if($emails) {
                                
                                // put the newest emails on top /
                                rsort($emails);
                                //for every email... /
                                foreach($emails as $email_number) {
                                    // get information specific to this email /
                                    
                                            
                             
                                    $overview = imap_fetch_overview($inbox,$email_number,0);
                                    //var_dump($overview);
                                    
                                    $cemail=$overview[0]->from; 
                                    $header = imap_header($inbox, $email_number);
                                    $to = $header->from;
                                    foreach ($to as $id => $object) {
                                    $toaddress = $object->mailbox . "@" . $object->host;
                                       
                                          
                                    if (in_array($toaddress, $clientemails)) {
                                             
                                    
                                    
                            ?>
                            <tr>
                                <td width="15%" style="border:2px solid gray;"> <?php echo $overview[0]->date;?> </td>
                                <td width="15%" style="border:2px solid gray;"> <?php echo $overview[0]->from;?> <br> <?php echo $toaddress;?> </td>
                                <?php
                                $plainmsg = imap_fetchbody($inbox,$email_number,1.2); 
                                //var_dump($plainmsg);
                               
                                if ($plainmsg == "") {
                                    $plainmsg = imap_fetchbody($inbox,$email_number,2);
                                }
                                $plainmsg = quoted_printable_decode($plainmsg);
                                ?>
                                
                                <td width="55%"  style="border:2px solid gray;" id="msg"><b> <?php echo $overview[0]->subject;?> </b><br> <?php echo $plainmsg;?> </td>
                                <?php
                                $structure = imap_fetchstructure($inbox, $email_number);
                                $attachments = array();
                                if(isset($structure->parts) && count($structure->parts)) {
                                    for($i = 0; $i < count($structure->parts); $i++) {
                                        $attachments[$i] = array(
                                            'is_attachment' => false,
                                            'filename' => '',
                                            'name' => '',
                                            'attachment' => ''
                                            );
                                    if($structure->parts[$i]->ifdparameters) {
                                        foreach($structure->parts[$i]->dparameters as $object) {
                                            if(strtolower($object->attribute) == 'filename') {
                                                $attachments[$i]['is_attachment'] = true;
                                                // var_dump($attachments[$i]['is_attachment']);
                                                $attachments[$i]['filename'] = $object->value;
                                               // var_dump( $attachments[$i]['filename']);
                                            }
                                        }
                                    } 
                                   
                                    if($structure->parts[$i]->ifparameters) 
                                    {
                                        foreach($structure->parts[$i]->parameters as $object) 
                                        {
                                            if(strtolower($object->attribute) == 'name') 
                                            {
                                                $attachments[$i]['is_attachment'] = true;
                                                $attachments[$i]['name'] = $object->value;
                                            }
                                        }
                                    }
                                   
                                    
                     
                                    if($attachments[$i]['is_attachment']) 
                                    {
                                        $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);
                                          
                                        if($structure->parts[$i]->encoding == 3) 
                                        { 
                                            $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                            
                                        }
                                    
                                        elseif($structure->parts[$i]->encoding == 4) 
                                        { 
                                            $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                                          
                                        } 
                                    } 
                                }
                            } 
                     
                            $is_attachment_true_flag = 0;
                            echo "<td width='15%' style='border:2px solid gray;'>";
                            foreach($attachments as $attachment)
                            {
                                
                                if($attachment['is_attachment'] == true)
                                {
                                    $is_attachment_true_flag++;
                                    $filename = $attachment['name'];
                                    if(empty($filename)) $filename = $attachment['filename'];
                     
                                    if(empty($filename)) $filename = time() . ".dat";
                              
                                    $fp = fopen("./" . $email_number . "-" . $filename, "w+");
                                    fwrite($fp, $attachment['attachment']);
                                    fclose($fp);
                                    ?>
                                     <?php echo "<a href='/anuvid/views/user/".$email_number."-".$filename."' download='$filename'> $filename</a><br>";?>  
                                    
                                    <?php  
                                }  

                            }
                             if($is_attachment_true_flag == 0) {
                               
                                echo "No Attachment";
                                
                            }
                            echo "</td>";
                            echo "</tr>";
                           
                           }
                           }
                                
                            }
                           
                           // if($count++ >= $max_emails) break;
                               
                        }  
                     
           
                     
                    
                    imap_close($inbox);
                    ?>