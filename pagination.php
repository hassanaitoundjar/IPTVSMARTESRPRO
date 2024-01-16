<?php
	if ($page == 0){$page = 1;}
	$prev = $page - 1;	
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;					
	

	$paginate = '';
	if($lastpage > 1){	
	    $paginate .= "<nav aria-label='Page navigation example'>";
		$paginate .= "<ul class='pagination justify-content-center'>";

		if ($page > 1){
			$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$prev'>Prev</a></li>";
		}else{
			$paginate.= "<li class='page-item'><a class='page-link'>Prev</a></li>";	
		}
	
		if ($lastpage < 7 + ($stages * 2)){	
			for ($counter = 1; $counter <= $lastpage; $counter++){
				if ($counter == $page){
					$paginate.= "<li class='page-item active'><a class='page-link' >$counter</a></li>";
				}else{
					$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$counter'>$counter</a></li>";}					
			}
		}else if($lastpage > 5 + ($stages * 2))	{

			if($page < 1 + ($stages * 2))		{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++){
					if ($counter == $page){
						$paginate.= "<li class='page-item active'><a class='page-link'>$counter</a></li>";
					}else{
						$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
				$paginate.= "<li class='page-item'><a class='page-link'>...</a></li>";
				$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$LastPagem1'>$LastPagem1</a></li>";
				$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$lastpage'>$lastpage</a></li>";	
				
			}else if($lastpage - ($stages * 2) > $page && $page > ($stages * 2)){
				$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=1'>1</a></li>";
				$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=2'>2</a></li>";
				$paginate.= "<li class='page-item'><a class='page-link'>...</a></li>";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++){
					if ($counter == $page){
						$paginate.= "<li class='page-item active'><a class='page-link'>$counter</a></li>";
					}else{
						$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$counter'>$counter</a></li>";
					    
					}					
				}
				$paginate.= "<li class='page-item'><a class='page-link'>...</a></li>";
				$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$LastPagem1'>$LastPagem1</a></li>";
				$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$lastpage'>$lastpage</a></li>";
				
			}else{
				$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=1'>1</a></li>";
				$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=2'>2</a></li>";
				$paginate.= "<li class='page-item'><a class='page-link'>...</a></li>";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++){
					if ($counter == $page){
						$paginate.= "<li class='page-item active'><a class='page-link'>$counter</a></li>";
					}else{
						$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
			}
		}

		if ($page < $counter - 1){ 
			$paginate.= "<li class='page-item'><a class='page-link' href='$targetpage?page=$next'>Next</a></li>";
		}else{
			$paginate.= "<li class='page-item'><a class='page-link'>Next</a></li>";
			}
			
		$paginate.= "</ul>";
		$paginate .= "</nav>";
    }
echo $paginate;
?>