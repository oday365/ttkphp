<?php
function E($msg, $code=0) {
    throw new TTkPHP\Exception($msg, $code);
}
