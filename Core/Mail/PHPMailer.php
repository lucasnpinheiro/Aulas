<?php

/**



use Core\Mail\SMTP;
use Core\Mail\XSMTP;

class PHPMailer
{











            $subject = $this->secureHeader($subject);
        } else {
            $subject = $this->encodeHeader($this->secureHeader($subject));
        }

















































































            $this->setError($this->lang('invalid_address') . ': ' . $address);
            $this->edebug($this->lang('invalid_address') . ': ' . $address);
            if ($this->exceptions) {
                throw new \Exception($this->lang('invalid_address') . ': ' . $address);
            }
            return false;
        }






















            $this->setError($this->lang('invalid_address') . ': ' . $address);
            $this->edebug($this->lang('invalid_address') . ': ' . $address);
            if ($this->exceptions) {
                throw new \Exception($this->lang('invalid_address') . ': ' . $address);
            }
            return false;
        }



















                    $patternselect = 'pcre8';
                } else {
                    $patternselect = 'pcre';
                }


                    $patternselect = 'php';
                } else {
                    $patternselect = 'noregex';
                }


































                $this->ContentType = 'multipart/alternative';
            }

                throw new \Exception($this->lang('empty_message'), self::STOP_CRITICAL);
            }


                if (count($this->to) > 0) {
                    $this->mailHeader .= $this->addrAppend("To", $this->to);
                } else {
                    $this->mailHeader .= $this->headerLine("To", "undisclosed-recipients:;");
                }
                $this->mailHeader .= $this->headerLine('Subject', $this->encodeHeader($this->secureHeader(trim($this->Subject))));
            }
                $header_dkim = $this->DKIM_Add($this->MIMEHeader . $this->mailHeader, $this->encodeHeader($this->secureHeader($this->Subject)), $this->MIMEBody);
                $this->MIMEHeader = rtrim($this->MIMEHeader, "\r\n ") . self::CRLF .
            }


























































































































































            if (!$this->smtp->recipient($to[0])) {
                $bad_rcpt[] = $to[0];
                $isSent = 0;
            } else {
                $isSent = 1;
            }
            $this->doCallback($isSent, $to[0], '', '', $this->Subject, $body, $this->From);
        }















































            return true;
        }



























































            throw $lastexception;
        }










































































































































































































            if ($this->SingleTo === true) {
                foreach ($this->to as $t) {
                    $this->SingleToArray[] = $this->addrFormat($t);
                }
            } else {
                if (count($this->to) > 0) {
                    $result .= $this->addrAppend('To', $this->to);
                } elseif (count($this->cc) == 0) {
                    $result .= $this->headerLine('To', 'undisclosed-recipients:;');
                }
            }
        }

            $result .= $this->addrAppend('Cc', $this->cc);
        }
            $result .= $this->addrAppend('Bcc', $this->bcc);
        }




            $result .= $this->headerLine('Subject', $this->encodeHeader($this->secureHeader($this->Subject)));
        }
























            $result .= $this->headerLine(trim($this->CustomHeader[$index][0]), $this->encodeHeader(trim($this->CustomHeader[$index][1])));
        }











            $result .= $this->headerLine('Content-Transfer-Encoding', $this->Encoding);
        }
























































































































                $type = self::filenameToType($path);
            }



























                $path = '';
                $bString = $attachment[5];
                if ($bString) {
                    $string = $attachment[0];
                } else {
                    $path = $attachment[0];
                }
                $inclhash = md5(serialize($attachment));
                if (in_array($inclhash, $incl)) {
                    continue;
                }
                $incl[] = $inclhash;
                $name = $attachment[2];
                $encoding = $attachment[3];
                $type = $attachment[4];
                $disposition = $attachment[6];
                $cid = $attachment[7];
                if ($disposition == 'inline' && isset($cidUniq[$cid])) {
                    continue;
                }
                $cidUniq[$cid] = true;
                $mime[] = sprintf("--%s%s", $boundary, $this->LE);
                $mime[] = sprintf("Content-Type: %s; name=\"%s\"%s", $type, $this->encodeHeader($this->secureHeader($name)), $this->LE);
                $mime[] = sprintf("Content-Transfer-Encoding: %s%s", $encoding, $this->LE);
                if ($disposition == 'inline') {
                    $mime[] = sprintf("Content-ID: <%s>%s", $cid, $this->LE);
                }
                    if (preg_match('/[ \(\)<>@,;:\\"\/\[\]\?=]/', $name)) {
                        $mime[] = sprintf("Content-Disposition: %s; filename=\"%s\"%s", $disposition, $this->encodeHeader($this->secureHeader($name)), $this->LE . $this->LE);
                    } else {
                        $mime[] = sprintf("Content-Disposition: %s; filename=%s%s", $disposition, $this->encodeHeader($this->secureHeader($name)), $this->LE . $this->LE);
                    }
                } else {
                    $mime[] = $this->LE;
                }
                    $mime[] = $this->encodeString($string, $encoding);
                    if ($this->isError()) {
                        return '';
                    }
                    $mime[] = $this->LE . $this->LE;
                } else {
                    $mime[] = $this->encodeFile($path, $encoding);
                    if ($this->isError()) {
                        return '';
                    }
                    $mime[] = $this->LE . $this->LE;
                }
            }
        }













































                    $encoded .= $this->LE;
                }



















            if (function_exists('mb_strlen') && $this->hasMultiBytes($str)) {
            } else {
                $encoded = base64_encode($str);
                $maxlen -= $maxlen % 4;
                $encoded = trim(chunk_split($encoded, $maxlen, "\n"));
            }
        } else {
            $encoding = 'Q';
            $encoded = $this->encodeQ($str, $position);
            $encoded = $this->wrapText($encoded, $maxlen, true);
            $encoded = str_replace('=' . self::CRLF, "\n", trim($encoded));
        }





































































            $type = self::filenameToType($filename);
        }








            $type = self::filenameToType($path);
        }









            $type = self::filenameToType($name);
        }

























































































































            $nstr = str_replace("\n", $this->LE, $nstr);
        }
















                    $filename = basename($url);
                    $directory = dirname($url);
                    if ($directory == '.') {
                        $directory = '';
                    }
                    $cid = md5($url) . '@phpmailer.0'; //RFC2392 S 2
                        $basedir .= '/';
                    }
                    if (strlen($directory) > 1 && substr($directory, -1) != '/') {
                        $directory .= '/';
                    }
                    if ($this->addEmbeddedImage($basedir . $directory . $filename, $cid, $filename, 'base64', self::_mime_types(self::mb_pathinfo($filename, PATHINFO_EXTENSION)))) {
                        $message = preg_replace("/" . $images[1][$i] . "=[\"']" . preg_quote($url, '/') . "[\"']/Ui", $images[1][$i] . "=\"cid:" . $cid . "\"", $message);
                    }
                }

























































































































































            $body = substr($body, 0, strlen($body) - 2);
        }
















































}