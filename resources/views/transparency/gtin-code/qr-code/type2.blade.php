<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head id="j_idt8"><script type="text/javascript">if(window.PrimeFaces){PrimeFaces.settings.locale='en_US';PrimeFaces.settings.validateEmptyFields=true;PrimeFaces.settings.considerEmptyStringNull=false;}</script>
<style type="text/css">

html {margin: 0; padding: 0;}
body {margin: 0; padding: 0; font-family: sans-serif; color-adjust: exact; print-color-adjust: exact; -webkit-print-color-adjust: exact !important;} 

@page {margin: 0; size: 1.75in 0.75in}

</style>
<title>Transparency Label</title>
</head>
<body style="width: 168px; height: 72px;">
@if(isset($htmlData) && !empty($htmlData))
	<?php $cnt = 1; ?>
    @foreach($htmlData as $key => $data)
		<table style="width: 168px; height: 72px; border-collapse: collapse; padding: 0; ">
			<tr>
				<td style="width: 20%; height: 65px; padding: 0; height: 72px; padding-left: 5px;">
					<img alt="Logo" src="{{ asset('assets/media/transparency-logo-black.png') }}" style="width: 33px;" />
				</td>
				<td style="width: 32%; padding: 0; height: 60px; padding-left: 4px;">
					<span style=" font-size: 8px; word-break: break-all; line-height: 2px;">Scan with the Transparency App</span>
				</td>
				<td style="text-align: center; padding: 0; height: 72px; padding: 0; ">
					<div style="margin-top: -2px; margin-left: -6px; position: relative;">
						<?=html_entity_decode(file_get_contents('storage/uploads/qr_code/'.$data['job_id'].'/'.$data['qrCodeImage']))?>
						<div style="font-size: 6px; letter-spacing: 0.5px; line-height: 6px; display: inline-block; margin-top: -10px; position: absolute; top: 72px; left: 10px;">{{ $data['gtin'] }}</div>
						<span style="font-size:6px; float: right; position: absolute; right: 3%; bottom: -8%">{{ $cnt++ }}</span>
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