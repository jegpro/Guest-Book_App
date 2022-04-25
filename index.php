<?php
session_start();
?><!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">  
		<title>Гостевая книга</title>
		<link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<div id="wrapper">
		  <h1>Гостевая книга</h1>  
<?php


// Поверка, есть ли GET запрос
if (isset($_GET['pageno'])) {
    // Если да то переменной $pageno присваиваем его
    $pageno = $_GET['pageno'];
} else { // Иначе
    // Присваиваем $pageno один
    $pageno = 1;
}
 
// Назначаем количество данных на одной странице
$size_page = 4;
// Вычисляем с какого объекта начать выводить
$offset = ($pageno-1) * $size_page;


class User
{
 
    public $name = "";
    public $pass = 0;

    
    public function __construct(string $name, int $pass)
    {
        $this->pass = password_hash($pass, PASSWORD_BCRYPT);
       
        $this->name = $name;
    }

}


$homepage = file_get_contents('guestbook.txt');

?> 

<?php
    
	$pieces = explode("[:|||:]", $homepage);

	$hello = $pieces[0];
	unset($pieces[0]);
	
		$count = count($pieces);
	
    // Отправляем запрос для получения количества элементов
    
    // Получаем результат
    $total_rows = $count;
    // Вычисляем количество страниц
    $total_pages = ceil($total_rows / $size_page);
    
    
	$pieces=array_reverse($pieces);

    $startPosition = $offset;
    $endPosition = $size_page;

    //print_r(array_slice($pieces, $startPosition, $endPosition));
	
	foreach(array_slice($pieces, $startPosition, $endPosition) as $key => $piece)
	{
	     echo('	<div class="note">');
	    $pieces1 = explode("[:||:]", $piece);
	    
	    
	    	unset($pieces1[0]);
	    	$o = 0;
	    	foreach($pieces1 as $key1 => $piece1)
	{
	    if($key1==4){continue;      }
	    
	    if($o==0)
	    echo("<p><span class='date'>".$piece1."</span>");
	    if($o==1)
	    echo("<span class='name'> ".$piece1."</span></p>");
	    if($o==2)
	    echo("<p>".$piece1."</span></p>"); 
	    $o++;
	}
	
	    echo('</div>');
	};
	
	?>

	<?php 
	  $count1=$_GET['pageno'];
	  if($count1!=true){
	      $count1=1;
	  }
	  for ($i=1; $i < $total_pages; $i++) { 
    if($i==$count1){
    ?>
    <a style="color:darkblue;" href="?pageno=<?php echo($i);?>"><?php echo ("[".$i."]"); ?></a>

    <?php
        
    }
    else {
	  ?>
    <a href="?pageno=<?php echo($i);?>"><?php echo ("[".$i."]"); ?></a>

 <?php } }
 
 if($total_pages==$_GET['pageno']){
    ?><a style="color:darkblue;" href="?pageno=<?php echo $total_pages; ?>"><?php echo ("[".$total_pages."]"); ?></a>
 <?php
 }
 else {
     ?><a href="?pageno=<?php echo $total_pages; ?>"><?php echo ("[".$total_pages."]"); ?></a>
 <?php
     
 }
 
  ?>	
	<br><br><?php if($_SESSION['a'] == 1){
    ?><div class="info alert alert-info">
				Запись успешно сохранена!
			</div><?php
}
$_SESSION['a'] = 2;?><?php 
if (isset($_GET['show']))
{    
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $two=$_POST['two'];
    if($_SESSION['true_auth']!=false){
         $one = $_SESSION['user'];
    }
    elseif($_SESSION['admin']=='admin'){
         $one = $_SESSION['admin'];
    }
    else{
    $one=$_POST['one'];}
    date_default_timezone_set("Europe/Moscow");
    $today = date("Y-m-d H:i:s");  
    $file='guestbook.txt';
    $current = file_get_contents($file);
       

    $current .= "[:|||:]7[:||:]".$today."[:||:]".$two."[:||:]".$one."[:||:]".$ip;
// Пишем содержимое обратно в файл
    file_put_contents($file, $current);
    $_SESSION['a'] = 1;
    
     ?>	
			</script><script>document.location.href="index.php"</script>
			
			<?php

} ?>
			<div id="form">
				<form action="?show" method="POST">
					<p><input class="form-control" name="two" placeholder="Ваше имя"></p>
					<p><textarea class="form-control" name="one" placeholder="Ваш отзыв"></textarea></p>
					<p><input type="submit" class="btn btn-info btn-block" value="Сохранить"></p>
				</form>
			</div>
		</div>

	</body>
</html>

