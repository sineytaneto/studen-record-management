<?php
require __DIR__ . '/config.php';
$user=require_login();
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT); if (!$id) { http_response_code(400); exit('Invalid file request.'); }
$q=db()->prepare('SELECT s.*,u.full_name FROM submissions s JOIN users u ON u.id=s.user_id WHERE s.id=?'); $q->execute([$id]); $s=$q->fetch();
if (!$s || ($user['role']!=='teacher' && (int)$s['user_id']!==(int)$user['id'])) { http_response_code(404); exit('File not found.'); }
$path=__DIR__.'/uploads/'.$s['stored_filename']; if (!is_file($path)) { http_response_code(404); exit('The stored file is missing.'); }
$name=str_replace(["\r","\n",'"'], '', basename($s['original_filename']));
header('X-Content-Type-Options: nosniff'); header('Content-Type: application/octet-stream'); header('Content-Length: '.filesize($path)); header('Content-Disposition: attachment; filename="'.$name.'"'); readfile($path); exit;
