<?php
// Formdan gönderilen verileri al
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Doğrulama kodunu oluştur
$verificationCode = generateVerificationCode(); // Özelleştirilmiş bir fonksiyon kullanmanız gerekebilir

// Doğrulama kodunu kullanıcıya gönder
sendVerificationEmail($email, $verificationCode); // Özelleştirilmiş bir fonksiyon kullanmanız gerekebilir

// Geri bildirim formunu doğrula
if (isset($_POST['submit'])) {
  $enteredCode = $_POST['verification_code'];

  if ($enteredCode === $verificationCode) {
    // Doğrulama başarılı, geri bildirim formunu e-posta ile gönder
    sendFeedbackEmail($name, $email, $message);
    echo "Geri bildirim gönderildi!";
  } else {
    echo "Doğrulama kodu yanlış!";
  }
}

// E-posta gönderme fonksiyonları
function sendVerificationEmail($email, $verificationCode) {
  $to = $email;
  $subject = "Doğrulama Kodu";
  $message = "Geri bildirim formunu göndermek için doğrulama kodu: " . $verificationCode;
  $headers = "From: example@gmail.com" . "\r\n" .
             "Reply-To: example@gmail.com" . "\r\n" .
             "X-Mailer: PHP/" . phpversion();

  // E-postayı gönder
  mail($to, $subject, $message, $headers);
}

function sendFeedbackEmail($name, $email, $message) {
  $to = "example@gmail.com";
  $subject = "Geri Bildirim";
  $message = "Ad: " . $name . "\n\nE-posta: " . $email . "\n\nMesaj: " . $message;
  $headers = "From: " . $email . "\r\n" .
             "Reply-To: " . $email . "\r\n" .
             "X-Mailer: PHP/" . phpversion();

  // E-postayı gönder
  mail($to, $subject, $message, $headers);
}

// Rastgele doğrulama kodu oluşturmak için bir fonksiyon
function generateVerificationCode() {
  $length = 6;
  $characters = '0123456789';
  $code = '';

  for ($i = 0; $i < $length; $i++) {
    $code .= $characters[rand(0, strlen($characters) - 1)];
  }

  return $code;
}
?>
