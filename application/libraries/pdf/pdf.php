<?php

require_once('tcpdf.php');

class Pdf
{
	public $orientation = 'P';
	public $unit = 'mm';
	public $page_fomat = 'A4';
	public $unicode = 'UTF-8';
	public $write_type = 'F';
	function __construct($config = array())
	{
		if(isset($config['orientation']))
			$this->orientation = $config['orientation'];
		if(isset($config['unit']))
			$this->unit = $config['unit'];
		if(isset($config['page_fomat']))
			$this->page_fomat = $config['page_fomat'];
		if(isset($config['unicode']))
			$this->unicode = $config['unicode'];
		if(isset($config['write_type']))
			$this->write_type = $config['write_type'];
	}
	
	function createPdf($file_name, $data=array())
	{
		require_once('lang/lang.php');
		$pdf = new TCPDF($this->orientation, $this->unit, $this->page_fomat, true, $this->unicode, false);

		$pdf->AddPage();
		
		$html = '';
		//header.
		$html .= '<table cellpadding="4" style="font-family: nimbussanl; color: #333333; font-size: 8px;">
					<tr>
						<td style="width: 40%;"></td>
						<td style="width: 20%;">
							<h1 style="text-align: center; margin-bottom: 20px; font-size: 24px; color: #f0f0f0; font-family: nimbussanl;">'.$lang['title'].'</h1>
						</td>
						<td colspan="2" style="text-align: right; width: 40%;">';
		if($data['logo'] != '')
		{
			$html .= '<img src="'.base_url($data['logo']).'" style="width: 110px; height: 40px;"/><br />';
		}
						$html .= '</td>
					</tr>

					<tr>
						<td rowspan="2" style="width: 40%; font-size: 8px;">
							<p style="font-size: 9px;">'.$data['shop_name'].'</p>
							<p><a style="color: #666;" href="'.$data['shop_url'].'">'.$data['shop_url'].'</a></p>
						</td>
						<td style="width: 20%;"></td>
						<td colspan="2" style="text-align: right; width: 40%;">
							<strong style="font-size: 11.5px; line-height: 2px;">'.$lang['title'].' #'.$data['order_number'].'</strong>
						</td>
					</tr>

					<tr>
						<td style="width: 20%;"></td>
						<td style="width: 22%; text-align: right;">
							'.$lang['date'].'<br />
							'.$lang['date_ship_by'].'<br />
							'.$lang['shipping'].'
						</td>
						<td style="width: 18%;">
							<b>'.$data['date'].'</b><br />
							<b>'.$data['date_ship'].'</b><br />
							<b>'.$data['status'].'</b><br />
						</td>
					</tr><br/>

					<tr style="background-color: #F7F7F9; color: #333333; ">
						<td style="width: 40%;">
							<strong>'.$lang['billing_address'].'</strong>
						</td>
						<td style="width: 20%;"></td>
						<td style="width: 40%;">
							<strong>'.$lang['shipping_address'].'</strong>
						</td>
					</tr><br />
					
					<tr>
						<td style="width: 40%;">';
						if(is_array($data['billing']))
						{
							$html .= '
								<table>
									<tr>
										<td>'.$lang['name'].':</td>
										<td>
											<a href="'.site_url().'" title="'.$data['billing']['name'].'">
												'.$data['billing']['name'].'
											</a>
										</td>
									</tr>
									<tr>
										<td>'.$lang['username'].'</td>
										<td>
											<a href="'.site_url().'" title="'.$data['billing']['name'].'">
												'.$data['billing']['username'].'
											</a>
										</td>
									</tr>
									<tr>
										<td>'.$lang['email'].':</td>
										<td>'.$data['billing']['email'].'</td>
									</tr>
								</table>';
						}
						
						$html .= '
						</td>
						<td style="width: 20%;"></td>
						<td style="width: 40%;">';
						if(is_array($data['address']))
						{
							$html .= '<table>';
							foreach($data['address'] as $key=>$val)
							{
								$html .= '<tr>';
								$html .= '<td>'.$key.': </td><td>'.$val.'</td>';
								$html .= '</tr>';
							}
							$html .= '</table>';
						}
						
						$html .= '
						</td>
					</tr><br />
				</table>
					<br /><br />
				<table cellpadding="4" style="font-family: nimbussanl; color: #333333; font-size: 8px; width: 100%;">
					<tr style="text-align: center; background-color: #F7F7F9; color: #333333;">
						<td style="width: 18%; border: 0.3px solid #ccc;">
							<span style="font-size: 4px;"><br/></span>
							<strong>'.$lang['name'].'</strong>
						</td>
						<td style="width: 6%; border: 0.3px solid #ccc;">
							<span style="font-size: 4px;"><br/></span>
							<strong>'.$lang['sku'].'</strong>
						</td>
						<td style="width: 14%; border: 0.3px solid #ccc;">
							<strong>'.$lang['status_of_ordered_products'].'</strong>
						</td>
						<td style="width: 8%; border: 0.3px solid #ccc;">
							<strong>'.$lang['product_price'].'</strong>
						</td>
						<td style="width: 6%; border: 0.3px solid #ccc;">
							<strong>'.$lang['print_price'].'</strong>
						</td>
						<td style="width: 7%; border: 0.3px solid #ccc;">
							<strong>'.$lang['price_clipart'].'</strong>
						</td>
						<td style="width: 9%; border: 0.3px solid #ccc;">
							<strong>'.$lang['price_attr'].'</strong>
						</td>
						<td style="width: 8%; border: 0.3px solid #ccc;">
							<span style="font-size: 4px;"><br/></span>
							<strong>'.$lang['quantity'].'</strong>
						</td>
						<td style="width: 15%; border: 0.3px solid #ccc;">
							<span style="font-size: 4px;"><br/></span>
							<strong>'.$lang['option'].'</strong>
						</td>
						<td style="width: 9%; border: 0.3px solid #ccc;">
							<span style="font-size: 4px;"><br/></span>
							<strong>'.$lang['total'].'</strong>
						</td>
					</tr>';
					
					$total = 0;
					$count = 1;
					$shipping_price = $data['shipping_price'];
					$payment_price = $data['payment_price'];
					if(is_array($data['items']))
					{
						foreach($data['items'] as $product)
						{
							$html .= '
							<tr>
								<td style="border: 0.3px solid #ccc;">
									'.$count.'. '.$product->product_name.'
								</td>
								<td style="text-align: center; border: 0.3px solid #ccc;">
									'.$product->product_sku.'
								</td>
								<td style="text-align: center; border: 0.3px solid #ccc;">
									'.$product->poduct_status.'
								</td>
								<td style="text-align: right; border: 0.3px solid #ccc;">
									'.$data['setting']->currency_symbol.number_format($product->product_price, 2).'
								</td>
								<td style="text-align: right; border: 0.3px solid #ccc;">
									'.$data['setting']->currency_symbol.number_format($product->price_print, 2).'
								</td>
								<td style="text-align: right; border: 0.3px solid #ccc;">
									'.$data['setting']->currency_symbol.number_format($product->price_clipart, 2).'
								</td>
								<td style="text-align: right; border: 0.3px solid #ccc;">
									'.$data['setting']->currency_symbol.number_format($product->price_attributes, 2).'
								</td>
								<td style="text-align: right; border: 0.3px solid #ccc;">
									'.$product->quantity.'
								</td>
								
								<td style="border: 0.3px solid #ccc;">';
									if($product->attributes != '' && $product->attributes != '"[]"')
									{
										$size = json_decode(json_decode($product->attributes), true);										
										if (count($size) > 0)
										{
											foreach($size as $option) { 
												$html .= '<div>
													<strong>'.$option['name'].': </strong>';
														if (is_string($option['value']))
														{
															$html .= $option['value'];
														}else if (is_array($option['value']) && count($option['value']))
														{
															foreach($option['value'] as $v=>$value)
															{
																if ($option['type'] == 'textlist')
																{
																	$html .= $v .' - '.$value.'; ';
																}else
																{
																	$html .= $value.'; ';
																}
															}
														}
												$html .= '</div>';
											}
										}
									}
									
								$html .='
								</td>';
								$total_row = $product->quantity*($product->product_price+$product->price_print+$product->price_clipart)+$product->price_attributes;
								$html .= '
								<td style="text-align: right; border: 0.3px solid #ccc;">
									'.$data['setting']->currency_symbol.number_format($total_row, 2).'
								</td>
							</tr>';
							$total = $total+$total_row;
							$count++;
						}
					}
					
					$html .= '
						<tr>
							<td colspan="9" style="text-align: right; border: 0.3px solid #ccc; ">Shipment Fee:';
							if (count($data['shipping'])) { 
								$html .= '
								<br><small><a href="'.site_url().'"><strong>'.$data['shipping']->title.'</strong></a></small>
								<br><small>'.$data['shipping']->description.'</small>';
								
							}
					$html .= '
						</td>
						<td style="text-align: right; border: 0.3px solid #ccc; ">
							'.$data['setting']->currency_symbol.number_format($shipping_price, 2).'
						</td>
					</tr>

					<tr>
						<td colspan="9" style="text-align: right; border: 0.3px solid #ccc; ">Payment Fee:';
						if (count($data['payment'])) {							
							$html .= '
							<br><small>'.lang('orders_admin_payment_method').': <a href="'.site_url().'"><strong>'.$data['payment']->title.'</strong></a></small>
							<br><small>'.$data['payment']->description.'</small>';
						}
					$html .= '
						</td>
						<td style="text-align: right; border: 0.3px solid #ccc; ">';
						$html .= $data['setting']->currency_symbol.number_format($payment_price, 2).'
						</td>
					</tr>
					
					<tr>
						<td colspan="9" style="text-align: right; border: 0.3px solid #ccc; ">Discount:';
						if (count($data['discounts'])) {							
							$html .= '<br><small>'.$data['discounts']->name.': <a href="'.site_url().'"><strong>
							'.$data['discounts']->code.'</strong></a></small>';
						}
					$html .= '
						</td>
						<td style="text-align: right; border: 0.3px solid #ccc; ">';
						$html .= $data['setting']->currency_symbol.number_format($data['discount'], 2).'
						</td>
					</tr>

					<tr>
						<td colspan="9" style="text-align: right; border: 0.3px solid #ccc; ">
							'.$lang['total'].'
						</td>
						<td style="text-align: right; border: 0.3px solid #ccc; ">';
							$total = $total + $shipping_price - $data['discount'];
						$html .= '
							<strong>'.$data['setting']->currency_symbol.number_format($total, 2).'</strong>
						</td>
					</tr>
				</table>';
		$pdf->writeHTML($html, true, 0, true, 0);
		
		$pdf->lastPage();
		
		// Product_detail.
		foreach($data['products'] as $product)
		{
			if(isset($product->vectors))
			{
				$pdf->AddPage();
				$html = '';
				$vectors = json_decode($product->vectors, true);
				if(is_array($vectors))foreach($vectors as $key=>$vector)
				{
					if(count($vector) != 0)
					{ 
						$html .= '
							<table style="font-family: nimbussanl; color: #333333; font-size: 8px; font-weight: bold;">
								<tr>
									<td style="text-align: center; width: 40%;">';
									if(isset($lang['design_'.$key.'_legend'])) $legend = $lang['design_'.$key.'_legend']; else $legend = '';
									$html .= $legend.'</td>
									<td></td>
								</tr>
								<tr>
									<td>';
									if(isset($product->image)){
										$html .= '<img src="'.rtrim($data['shop_url'], '/').'/'.str_replace('front', $key, $product->image).'" alt=""/>';
									}
									$html .= '
									</td>
									<td>';
									$subtable = '';
									$subtable .= '<table>';
										foreach($vector as $value){
											$subtable .= '
											<tr>
												<td>';
												if(isset($value['type'])){
													$subtable .= '<label>';
													if(isset($lang['design_'.$value['type'].'_label'])) $label = $lang['design_'.$value['type'].'_label']; else $lable = '';
													$subtable .= $label.'</label>';
												}
												$subtable .= '
												</td>
												<td colspan="2">';
												if(isset($value['text'])){
													$subtable .= '<p style="font-weight: normal; font-size: 10px;">'.$value['text'].'</p>';
												}else if(isset($value['thumb'])){
													$subtable .= '<img src="'.$value['thumb'].'" alt=""/>';
												}
												$subtable .= '
												</td>
											</tr>';
											foreach($value as $k=>$v){
												if($k != 'text' && $k != 'zIndex' && $k != 'type' && $k != 'svg' && $k != 'outlineC' && $k != 'outlineW' && $k != 'title' && $k != 'file_name' && $k != 'file' && $k != 'thumb' && $k != 'url' && $k != 'change_color'){
													$subtable .= '
														<tr>
															<td></td>';
															if(isset($lang[$k])) $attr = $lang[$k]; else $attr = '';
															if($k == 'fontFamily')
																$subtable .= '<td>'.$attr.'</td><td><a target="_blank" href="http://www.google.com/fonts/specimen/'.str_replace(' ', '+', $v).'" title="Click to download this font">'.$v.'</a></td></tr>';
															else
																$subtable .= '<td>'.$attr.'</td><td>'.$v.'</td></tr>';
												}else if(($k == 'outlineC' || $k == 'outlineW') && $v != 'none'){
													$subtable .= '
														<tr>
															<td></td>';
															if(isset($lang[$k])) $attr = $lang[$k]; else $attr = '';
															$subtable .= '<td>'.$attr.'</td><td>'.$v.'</td></tr>';
												}
											}
										}
										$subtable .= '</table>';
										
									$html .= 
									$subtable.'</td>
								</tr>
							</table><br /><hr /><p></p>';
					}
				}
				$pdf->writeHTML($html, true, 0, true, 0);
		
				$pdf->lastPage();
			}
		}
		$pdf->Output($file_name, $this->write_type);
	}
}