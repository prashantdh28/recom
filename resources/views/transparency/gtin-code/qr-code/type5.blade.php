<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head id="j_idt8"><script type="text/javascript">if(window.PrimeFaces){PrimeFaces.settings.locale='en_US';PrimeFaces.settings.validateEmptyFields=true;PrimeFaces.settings.considerEmptyStringNull=false;}</script>
<style type="text/css">

html {margin: 0; padding: 0;}
body {margin: 0; padding: 0; width: 4in; font-family: sans-serif; color-adjust: exact; print-color-adjust: exact; -webkit-print-color-adjust: exact !important;} 

@page {margin: 0; size: 2in 1in}

</style>
<title>Transparency Label</title>
</head>
<body>
@if(isset($htmlData) && !empty($htmlData))
	<?php $cnt = 1; ?>
    @foreach($htmlData as $key => $data)
		<table style="width: 192; height: 96px; border-collapse: collapse; padding: 0;">
			<tr>
				<td style="width: 20%; height: 65px; height: 72px; padding-left: 15px;">
					<img src="{{ asset('assets/media/transparency-logo-black.png') }}" style="width: 50px;" />
				</td>
				<td style="width: 40%; height: 60px; padding-left: 8px;">
					<span style=" font-size: 10px; word-break: break-all; line-height: 2px;">Scan with the Transparency App</span>
				</td>
				<td style="text-align: center; height: 72px; padding: 0 10px; text-align: right; ">
					<div style="margin-top: -6px; margin-left: 0px; position: relative;">
						<?=html_entity_decode(file_get_contents('storage/uploads/qr_code/'.$data['job_id'].'/'.$data['qrCodeImage']))?>
						<div style="font-size: 9px; letter-spacing: 0.5px; line-height: 9px; display: inline-block; margin-top: -10px; position: absolute; top: 92px; right: 10px;">{{ $data['gtin'] }}</div>
					</div>
				</td>
			</tr>
		</table>
	@endforeach
@endif
<input id="printer_name" type="hidden" name="printer_name" />
<script type="text/javascript">
var printerName = '';
// window.print();
</script></body>
</html>