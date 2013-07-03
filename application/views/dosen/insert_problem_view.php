<html>
    <head>
        <title>Insert Problem | d2hwebmaster</title>
    </head>
    <body>
        <?php if(!empty($message)) { echo $message; } ?>

        <?php echo form_open_multipart('dosen/insert_problem'); ?>

        <input type="file" name="insert_file_problem" size="20" />
        <?php if(!empty($upload_error)) { echo $upload_error; } ?>
        <br /><br />

        <input type="submit" name="add_problem" value="Add Problem" />

    </form>
</body>
</html>