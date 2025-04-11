<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head id="j_idt8"><script type="text/javascript">if(window.PrimeFaces){PrimeFaces.settings.locale='en_US';PrimeFaces.settings.validateEmptyFields=true;PrimeFaces.settings.considerEmptyStringNull=false;}</script>
<style type="text/css">

html {margin: 0; padding: 0;}
body {margin: 0; padding: 0; font-family: sans-serif; color-adjust: exact; print-color-adjust: exact; -webkit-print-color-adjust: exact !important;} 

@page {margin: 0; size: 1.375in}

</style>
<title>Transparency Label</title>
</head>
<body style="width: 132px; height: 132px;">
	@if(isset($htmlData) && !empty($htmlData))
		<?php $cnt = 1; ?>
		@foreach($htmlData as $key => $data)
			<table style="border-collapse: collapse; width: 100%; position: relative;">
				<tr>
					<td style="width: 100%; position: relative;">
						<span style="font-size: 8px; top:4px; left: 4px; position: absolute; ">{{ $cnt++ }}</span>
						<table style="width: 100%; border-collapse: collapse;">
							<tr style="vertical-align: middle;">
								<td style="width: 50%; padding-left: 5px;">
									<div style="padding-left: 8px; padding-top: 4px;">
										<img alt="Logo" src="{{ asset('assets/media/transparency-logo-black.png') }}" style="width: 30px;" />
									</div>
									<span style="font-size: 8px; line-height: 12px; display: inline-block;">Scan with the Transparency App </span>
								</td>
								<td style="width: 50%;">
									<?=html_entity_decode(file_get_contents('storage/uploads/qr_code/'.$data['job_id'].'/'.$data['qrCodeImage']))?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="text-align: center; padding-top: 4px;">
						<?=html_entity_decode(file_get_contents('storage/uploads/qr_code/'.$data['job_id'].'/product_barcode/'.$data['barcodeImage']))?>
						<span style="font-size: 14px; line-height: 14px; text-align: center; display: inline-block; margin-top: -10px;">
							{{ $data['gtin'] }}
						</span>
					</td>
				</tr>
			</table>
		@endforeach
	@endif
	<input id="printer_name" type="hidden" name="printer_name" />
	<script type="text/javascript">
	var printerName = '';
	// window.print();
	</script>
</body>
</html>