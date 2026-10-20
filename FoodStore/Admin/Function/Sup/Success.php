<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


<?php
function Add()
{
?>
        <script type="text/javascript">
            Toastify({
                text: `Thêm thành công!`,
                avatar:`https://img.icons8.com/fluency/48/null/checked.png`,
            }).showToast();
        </script>
<?php
}
?>
<?php
function Edit()
{
?>
        <script type="text/javascript">
            Toastify({
                text: `Cập nhật thành công!`,
                avatar:`https://img.icons8.com/fluency/48/null/checked.png`,
            }).showToast();
        </script>
<?php
}
?>
<?php
function Delete()
{
?>
        <script type="text/javascript">
            Toastify({
                text: `Xoá thành công!`,
                avatar:`https://img.icons8.com/fluency/48/null/checked.png`,
            }).showToast();
        </script>
<?php
}
?>
<?php
function trang_truoc(){
		?>
			<html><head>
			  <meta charset="UTF-8">
			  <title>Đang chuyển về trang trước</title></head>
			<body>
				<script type="text/javascript">
					window.history.back();
				</script>	
			</body>
			</html>
		<?php 
	}
    ?>


<?php
function SuccessOder()
{
?>
        <script type="text/javascript">
            Toastify({
                text: `Xác nhận đơn hàng thành công!`,
                avatar:`https://img.icons8.com/fluency/48/null/checked.png`,
            }).showToast();
        </script>
<?php
}
?>