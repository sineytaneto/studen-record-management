<?php
require __DIR__ . '/config.php';
$teacher=require_role('teacher');
if ($_SERVER['REQUEST_METHOD']!=='POST') { header('Location: dashboard.php'); exit; }
check_csrf();
$id=filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT); $decision=$_POST['decision']??''; $remarks=trim($_POST['remarks']??'');
if (!$id || !in_array($decision,['approved','returned'],true)) { flash('Invalid review request.','error'); header('Location: dashboard.php'); exit; }
if ($decision==='returned' && $remarks==='') { flash('Add a remark explaining what the student needs to fix before returning the submission.','error'); header('Location: dashboard.php'); exit; }
$q=db()->prepare('UPDATE submissions SET status=?,teacher_remarks=?,reviewed_by=?,reviewed_at=NOW() WHERE id=?');
$q->execute([$decision,$remarks!==''?$remarks:null,$teacher['id'],$id]);
flash($q->rowCount()?'Submission review saved.':'No change was made; the submission may not exist.',$q->rowCount()?'success':'error'); header('Location: dashboard.php'); exit;
