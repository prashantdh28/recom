<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head id="j_idt8"><script type="text/javascript">if(window.PrimeFaces){PrimeFaces.settings.locale='en_US';PrimeFaces.settings.validateEmptyFields=true;PrimeFaces.settings.considerEmptyStringNull=false;}</script>
<style type="text/css">

html {margin: 0; padding: 0;}
body {margin: 0; padding: 0; font-family: sans-serif; color-adjust: exact; print-color-adjust: exact; -webkit-print-color-adjust: exact !important;} 

@page {margin: 0; size: 28.6mm 28.6mm}

</style>
<title>Transparency Label</title>
</head>
<body style="width: 108px; height: 108px; font-size: 12px;">
@if(isset($htmlData) && !empty($htmlData))
	<?php $cnt = 1; ?>
    @foreach($htmlData as $key => $data)
		<table style="width: 108px; height: 108px; border-collapse: collapse; overflow: hidden;">
			<tr>
				<td>
					<table style="border-collapse: collapse;">
						<tr style="vertical-align: middle;">
							<td style="width: 50%; height: 30px;">
                            	<img alt="Logo" src="{{ asset('assets/media/transparency-logo-black.png') }}" style="height: 30px;" />
							</td>
							<td>
								<span style="width: 50%; font-size: 10px;">Scan with the Transparency App </span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr style="overflow: hidden;">
				<td style="text-align: center; padding: 0;">
					<div style="margin-top: -15px;">
						<div style="transform: rotate(-90deg); transform-origin: 120%; font-size: 6px; letter-spacing: 0.75px; line-height: 0; display: inline-block;">{{ $data['gtin'] }}</div>
						<?=html_entity_decode(file_get_contents('storage/uploads/qr_code/'.$data['job_id'].'/'.$data['qrCodeImage']))?>
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