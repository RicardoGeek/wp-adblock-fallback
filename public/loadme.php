<?php
  header ("Content-type: application/javascript");
?>



window.onload = function() {
  
  function adBlockNotDetected() {
    alert('AdBlock is not enabled');
  }

  function adBlockDetected() {
    alert('AdBlock is enabled');
  }


  if(typeof fuckAdBlock === 'undefined') {
    adBlockDetected();
  } else {
    fuckAdBlock.on(true, adBlockDetected).onNotDetected(adBlockNotDetected);
  }

  fuckAdBlock.setOption('checkOnLoad', true);
}
