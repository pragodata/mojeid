<?php require_once('common.php'); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<xrds:XRDS xmlns:xrds="xri://$xrds" xmlns="xri://$xrd*($v*2.0)">
  <XRD>
    <Service>
      <Type>http://specs.openid.net/auth/2.0/return_to</Type>
      <URI><?php echo getReturnTo(); ?></URI>
    </Service>
  </XRD>
</xrds:XRDS>