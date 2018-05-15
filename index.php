<?php
    // MySQLサーバ接続に必要な値を変数に代入
    $username = 'root';
    $password = '';

   
    $database = new PDO('mysql:host=localhost;dbname=message_board_DB;charset=UTF8;', $username, $password);


    if ($_POST['message']) {
        
        $sql = 'INSERT INTO message_data (message,writer) VALUES(:message,:writer)';
        
        $statement = $database->prepare($sql);
        
        $statement->bindParam(':writer', $_POST['writer']);
        $statement->bindParam(':message', $_POST['message']);
        
        $statement->execute();
      
        $statement = null;
    }
    
    if ($_POST['del_message']) {
        
        $sql = 'DELETE FROM message_data WHERE message=:del_message';
 
        $statement = $database->prepare($sql);
       
        $statement->bindParam(':del_message', $_POST['del_message']);
        
        $statement->execute();
   
        $statement = null;
    }
    
    if ($_POST['up_message']) {
        
        $sql = 'UPDATE message_data SET message=:up_message WHERE message=:ori_message';
        
        $statement = $database->prepare($sql);
        
        $statement->bindParam(':ori_message', $_POST['ori_message']);
        $statement->bindParam(':up_message', $_POST['up_message']);
        
        $statement->execute();
      
        $statement = null;
    }

   
    $sql = 'SELECT * FROM message_data ORDER BY created_at';
  
    $statement = $database->query($sql);
   
    $records = $statement->fetchAll();


    $statement = null;
   
    $database = null;
?>

<!--tab.html-->
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <title>Message Board</title>
     <link rel="stylesheet" href="./CSS/index.css">
</head>
<body>
     
    <input type="radio" name="rad" id="sel1" checked>
    <label for="sel1">Message board</label>
    <input type="radio" name="rad" id="sel2">
    <label for="sel2">New & Delete</label>
    <div id="tab1">
        
        <table>
            <tbody>
                <tr>
                    <td>No.</td>
                    <td>Message</td>
                    <td>Writer</td>
                    <td>Date</td>
                </tr>
                <?php
                    $numbering=1;
                    if ($records) {
                        foreach ($records as $record) {
                            $id = $record['id'];
                            $message = $record['message'];
                            $writer = $record['writer'];
                            $time = $record['created_at'];
                ?>  
                <tr>
                    <td><?php print($numbering);$numbering++; ?></td>
                    <td><a href="#"><?php print htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></a></td>
                    <td><a href="#"><?php print htmlspecialchars($writer, ENT_QUOTES, 'UTF-8'); ?></a></td>
                    <td><?php print htmlspecialchars($time, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <?php
                                                        }
                                    }
                ?>
                <tr>
                    <td>
                        <select>
                            <option>Title</option>
                            <option>Message</option>
                            <option>writer</option>
                        </select>
                    </td>
                    <td colspan="2">
                        <input type="text" required>
                    </td>
                    <td>
                        <input type="submit" value="Serach">
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>
    <div id="tab2">
        <h1>Add the new message</h1>
        <h1><a href="index.php"></a></h1>
        <form action="index.php" method="POST">
            <input type="text" name="writer"placeholder="write the name" required>
            <input type="text" name="message" placeholder="write the message" required>
            <input type="submit" name="submit_POST_message" value="登録">
        </form>
        
        <h1>Delete the message</h1>
        <form action="index.php" method="POST">
            <input type="text" name="del_message" placeholder="delete the message" required>
            <input type="submit" name="submit_del_message" value="消去"/>
        </form>
        
        <h1>Update the message</h1>
        <form action="index.php" method="POST">
            <input type="text" name="ori_message" placeholder="Original message" required>
            <input type="text" name="up_message" placeholder="Update the message" required>
            <input type="submit" name="submit_up_message" value="更新"/>
        </form>
    </div>
</body>
</html>