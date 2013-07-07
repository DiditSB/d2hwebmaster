<html>
    <head>
        <title>Upload Form</title>
    </head>
    <body>

        <?php echo isset($error) ? $error : ''; ?>

        <?php echo form_open_multipart('index/upload'); ?>

        <input type="file" name="userfile" size="20" />

        <br /><br />

        <input type="submit" name="file_upload" value="upload" />

    </form>
    <?php isset($data) ? print_r($data) : '';
    echo $_SERVER["DOCUMENT_ROOT"];
    echo file_exists($_SERVER["DOCUMENT_ROOT"].'/file/');
    $url = urlencode(base_url('index/download/781b1431fa5a8d389ad07f0a15df8cd7'));
    echo $url;
    
//    $params = array(
//      'http' => array
//      (
//          'method' => 'POST',
//          'header'=>"Content-Type: multipart/form-data\r\n"
//      ));
//    
//    // Open the file using the HTTP headers set above
//    $file = file_get_contents(base_url('index/download/781b1431fa5a8d389ad07f0a15df8cd7'), false, $context);
//    echo $file;
    ?>
    <?php
    $path = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/";
    echo urlencode($path);
    
    $arr_str_replace = array('-', ':', ' '); // array for replace
    $problem_date_end = str_replace($arr_str_replace, '', '0000-00-00 00:00:00'); // make 2013-03-22 10:21:23 to 20130322102123
    echo $problem_date_end;
    ?>
    <iframe src="http://docs.google.com/viewer?url=http%3A%2F%2Flocalhost%2Fdosen%2Fproblems%2F9f044cf0ea0a1c411c6fe3e78b813a77.pdf&embedded=true" width="600" height="780" style="border: none;"></iframe>
    <iframe src="http://docs.google.com/viewer?url=http%3A%2F%2Fwww.d2hwebmaster.hol.es%2Ffile%2F5cbdd052dc5217eb471a3490a823a8cd.pdf&embedded=true" width="600" height="780" style="border: none;"></iframe>
</body>
</html>