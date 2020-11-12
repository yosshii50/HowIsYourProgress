
// 色情報変換関係

// 表示に必要なHTML出力
document.write('<canvas id="Wrk_Color2RGB_CanvasID" width="1" height="1" style="display:none;"></canvas><br>');

class ColorControl_Cls
{
	
	// 色情報文字列 から RGB文字列('#FFFFFF')に変換
	Color2RGB( ColorStr , CanvasID ){
		
		// 作業用CanvasIDのElementとContext取得
		var Canvas_Element = document.getElementById( CanvasID );
		var Canvas_Context = Canvas_Element.getContext("2d");
		
		// 一度中身を消しておく
		Canvas_Context.fillStyle = 'black';
		Canvas_Context.fillRect( 0 , 0 , 1 , 1 );
		
		// １ピクセル描画
		Canvas_Context.fillStyle = ColorStr;
		Canvas_Context.fillRect( 0 , 0 , 1 , 1 );
		
		// 描画した１ピクセル取得
		// getImageData.data から RGB文字列('#FFFFFF')に変換
		return this.ColorData2RGB( Canvas_Context.getImageData(0, 0, 1, 1).data );
	}
	
	// getImageData.data から RGB文字列('#FFFFFF')に変換
	ColorData2RGB( ImageData_Data ){
		return '#' + (('0' + ImageData_Data[0].toString(16).toUpperCase()).substr(-2))
		           + (('0' + ImageData_Data[1].toString(16).toUpperCase()).substr(-2))
		           + (('0' + ImageData_Data[2].toString(16).toUpperCase()).substr(-2));
	}
	
	// Percentに応じた中間色を取得
	// Percentは 0～1 (0.5等)
	GetProgressColorStr( FrColorStr , ToColorStr , Percent , CanvasID ){
		
		var FrColorRGB = this.Color2RGB( FrColorStr , CanvasID );
		var ToColorRGB = this.Color2RGB( ToColorStr , CanvasID );
		
		return this.GetProgressColorRGB( FrColorRGB , ToColorRGB , Percent );
	}
	
	// Percentに応じた中間色を取得
	// Percentは 0～1 (0.5等)
	// 色情報は16進RGB #000000～#FFFFFFの文字列
	GetProgressColorRGB( FrColorRGB , ToColorRGB , Percent ){
		
		var FrColorRGB = new ColorControl_ColorRGB_Cls( FrColorRGB );
		var ToColorRGB = new ColorControl_ColorRGB_Cls( ToColorRGB );
		
		var RetColorRGB = '#' + this.GetHalfwayHex( FrColorRGB.HexR , ToColorRGB.HexR , Percent )
		                      + this.GetHalfwayHex( FrColorRGB.HexG , ToColorRGB.HexG , Percent )
		                      + this.GetHalfwayHex( FrColorRGB.HexB , ToColorRGB.HexB , Percent );
		
		return RetColorRGB;
	}
	
	// Percentに応じた中間数を取得
	// Percentは 0～1 (0.5等)
	// 数値は16進数 00～FFの文字列
	GetHalfwayHex( SrcHex , DstHex , Percent ){
		
		var SrcInt = parseInt( SrcHex , 16 );
		var DstInt = parseInt( DstHex , 16 );
		var WayInt;
		
		if( SrcInt > DstInt ){
			WayInt = Math.round( ( SrcInt - DstInt ) * ( 1 - Percent ) + DstInt );
		} else {
			WayInt = Math.round( ( DstInt - SrcInt ) * Percent + SrcInt );
		}
		
		return (('0' + WayInt.toString(16).toUpperCase()).substr(-2));
	}
	
}

// 16進RGBi #xxxxxx を分割
class ColorControl_ColorRGB_Cls
{
	constructor( ColorRGB )
	{
		this.ColorRGB = ColorRGB;
		this.HexR = ColorRGB.substring(1,3);
		this.HexG = ColorRGB.substring(3,5);
		this.HexB = ColorRGB.substring(5,7);
	}
}

