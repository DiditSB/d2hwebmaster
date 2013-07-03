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
    <iframe src="http://docs.google.com/viewer?url=<?php echo urlencode(base_url('index/download/781b1431fa5a8d389ad07f0a15df8cd7')); ?>&embedded=true" width="600" height="780" style="border: none;"></iframe>
</body>
</html>