<?php
// ...existing code...
require_once '../backend/database.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $subject = $_POST['subject_name'];
    $note = $_POST['note'];
    $db->insert("INSERT INTO FeedBack (firstname, lastname, email, phone_number, subject_name, note) 
        VALUES ('$firstname', '$lastname', '$email', '$phone', '$subject', '$note')");
}


$feedbacks = $db->select("SELECT * FROM FeedBack ORDER BY created_at DESC LIMIT 5");
?>


<form method="POST" class="review-form" style="margin-top:2rem;">
    <div class="review-title">Gửi phản hồi</div>
    <input class="review-input" type="text" name="firstname" placeholder="Họ" required>
    <input class="review-input" type="text" name="lastname" placeholder="Tên" required>
    <input class="review-input" type="email" name="email" placeholder="Email" required>
    <input class="review-input" type="text" name="phone_number" placeholder="Số điện thoại">
    <input class="review-input" type="text" name="subject_name" placeholder="Chủ đề" required>
    <textarea class="review-textarea" name="note" placeholder="Nội dung" required></textarea>
    <button class="review-button" type="submit" name="submit_feedback">Gửi phản hồi</button>
</form>


<div class="feedback-list" style="margin-top:2rem;">
    <h3>Phản hồi mới nhất</h3>
    <?php if ($feedbacks): foreach ($feedbacks as $fb): ?>
        <div class="feedback-item" >
            <b><?php echo $fb['firstname'] . ' ' . $fb['lastname']; ?></b>
            <span >(<?php echo $fb['email']; ?>)</span><br>
            <span ><?php echo $fb['subject_name']; ?></span><br>
            <span><?php echo nl2br($fb['note']); ?></span>
        </div>
    <?php endforeach; else: ?>
        <p>Chưa có phản hồi nào.</p>
    <?php endif; ?>
</div>