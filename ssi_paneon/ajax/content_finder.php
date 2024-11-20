<?php

?>
<script type="text/javascript">
  function resizeIframe(obj){ 
	 obj.style.height = 0;
     obj.style.height = $( document ).height() - 90 + 'px';
  }
</script>
<iframe class="iframe"  src='../ssi_finder/index.php' frameBorder='0' scrolling='auto' width=100% height=100% onload='resizeIframe(this)' allowtransparency="true"></iframe>
