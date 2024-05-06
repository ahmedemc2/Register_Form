<?php


$myInfo = [

    'username' => $_POST['user'],
    'email' => $_POST['mail'],
    'pswd' => $_POST['password'],
    'rePswd' => $_POST['rePassword'],
    'phoneNum' => $_POST['phone'],
    'birthday' => $_POST['Birth'],
    'gender' => $_POST['gender'],
    'languages' => $_POST['lang'],
    'add_1' => $_POST['address1'],
    'add_2' => $_POST['address2'],
    'country' => $_POST['country'],
    'city' => $_POST['city'],
    'region' => $_POST['region'],
    'postalCode' => $_POST['Pcode']
];

echo '<pre>';
print_r($myInfo);
echo '</pre>';

$languages = $_POST['lang'];
$nbr_lang = count($languages);

$dsn = 'mysql:host=localhost;dbname=logins';
$user = 'register';
$pass = 'rCt0oNlXZGmCWP]F';

try {
    $connectPdo = new PDO($dsn, $user, $pass);
    echo "Connected Successfuly<br>";
    $inserting = $connectPdo->prepare('INSERT INTO logins(fullName, eMail, passwd, rePasswd, phoneNum, birthDay, gender, language_1, language_2, language_3, language_4, language_5, Address_1, Address_2, country, city, region, postalCode) VALUES (:username, :email, :pswd, :rePswd, :phoneNum, :birthday, :gender, :language_1, :language_2, :language_3, :language_4, :language_5, :add_1, :add_2, :country, :city, :region, :postalCode)');

    $inserting->bindParam(':username', $myInfo['username']);
    $inserting->bindParam(':email', $myInfo['email']);
    $inserting->bindParam(':pswd', $myInfo['pswd']);
    $inserting->bindParam(':rePswd', $myInfo['rePswd']);
    $inserting->bindParam(':phoneNum', $myInfo['phoneNum']);
    $inserting->bindParam(':birthday', $myInfo['birthday']);
    $inserting->bindParam(':gender', $myInfo['gender']);
    for ($i = 1; $i <= $nbr_lang; $i++) {
        $inserting->bindValue(":language_$i", $myInfo['languages'][$i - 1]);
    }
    if ($nbr_lang < 5) {
        for ($i = $nbr_lang + 1; $i <= 5; $i++) {
            $inserting->bindValue(":language_$i", NULL, PDO::PARAM_NULL);
        }
    }
    $inserting->bindParam(':add_1', $myInfo['add_1']);
    $inserting->bindParam(':add_2', $myInfo['add_2']);
    $inserting->bindParam(':country', $myInfo['country']);
    $inserting->bindParam(':city', $myInfo['city']);
    $inserting->bindParam(':region', $myInfo['region']);
    $inserting->bindParam(':postalCode', $myInfo['postalCode']);

    $inserting->execute();
} catch (PDOException $error) {
    echo "Message Error: " . $error->getMessage();
}
