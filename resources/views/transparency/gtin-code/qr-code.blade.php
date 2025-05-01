<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head id="j_idt8"><script type="text/javascript">if(window.PrimeFaces){PrimeFaces.settings.locale='en_US';PrimeFaces.settings.validateEmptyFields=true;PrimeFaces.settings.considerEmptyStringNull=false;}</script>
<style type="text/css">

html {margin: 0; padding: 0;}
body {margin: 0; padding: 0; font-family: sans-serif; color-adjust: exact; print-color-adjust: exact; -webkit-print-color-adjust: exact !important;} 

@page {margin: 0; size: 4in 1.375in}

</style>
<title>Transparency Label</title>
</head>
<body style="width: 384px; height: 132px;">
@if(isset($htmlData) && !empty($htmlData))
	<?php $cnt = 1; ?>
    @foreach($htmlData as $key => $data)
		<table style="width: 100%; height: 132px; border-collapse: collapse; table-layout: fixed; position: relative;">
			<tr style="vertical-align: middle;">
				<td style="width: 108px;">
					<table style="width: 100%; border-collapse: collapse; padding: 0; margin: 0;">
						<tr>
							<td style="padding: 4px 4px 0 4px;">
								<table>
									<tr>
										<td>
											<div>
												<img alt="Logo" src="{{ asset('assets/media/transparency-logo-black.png') }}" style="height: 30px;" />
											</div>
										</td>
										<td>
											<span style="font-size: 10px; display: inline-block; line-height: 10px; padding-left: 4px;">Scan with the Transparency App </span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style="text-align: center;">
								<?=html_entity_decode(file_get_contents('storage/uploads/qr_code/'.$data['job_id'].'/'.$data['qrCodeImage']))?>
							</td>
						</tr>
					</table>
				</td>
				<td style="border-left: 1px solid #cdcdcd;">
					<div>
						<div>
							<span>{{ $data['brand'] }}</span>
						</div>
						<div style="text-align: center;margin-top: 5px;">
							<?=html_entity_decode(file_get_contents('storage/uploads/qr_code/'.$data['job_id'].'/product_barcode/'.$data['barcodeImage']))?>
						</div>
						<div style="font-size: 10px; text-align: center;">
							{{ $data['fnsku'] }}
						</div>
						<div style="font-size: 10px; margin-top: 8px; margin-left: 4px;">
							<div>
								{!! wordwrap(substr($data['title'],0,120), 35, "\n") !!}
							</div>
							<div>
								@if(!empty($data['product_condition']))
									{{ strtoupper($data['product_condition']) }}
								@endif
							</div>
						</div>
						<span style="font-size:10px; position: absolute; right: 3px; bottom: 2px;">{{ $cnt++ }}</span>
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