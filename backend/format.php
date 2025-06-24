<?php
// Format Class
class Format {

    // Định dạng ngày tháng
    public function formatDate($date) {
        return date('F j, Y, g:i a', strtotime($date));
    }

    // Rút ngắn nội dung văn bản
    public function textShorten($text, $limit = 400) {
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' '));
        $text .= "...";
        return $text;
    }

    // Validation dữ liệu đầu vào (làm sạch dữ liệu)
    public function validation($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Tạo tiêu đề từ tên file PHP
    public function title() {
        $path = $_SERVER['SCRIPT_FILENAME'];
        $title = basename($path, '.php');

        if ($title == 'index') {
            $title = 'home';
        } elseif ($title == 'contact') {
            $title = 'contact';
        }

        return ucfirst($title);
    }
}
?>
