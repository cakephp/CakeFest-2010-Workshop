{
	"success": true,
	"message": <?php echo json_encode($this->Session->flash()) ?>,
	"data": <?php echo $content_for_layout;?>
}