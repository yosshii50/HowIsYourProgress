
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
	
}
