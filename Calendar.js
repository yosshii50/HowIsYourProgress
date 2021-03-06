
// カレンダー表示

class OneDay_Cls {
	
	MsgOut( BaseColor ) {
		
		var ColorControl = new ColorControl_Cls();
		
		document.write( '<canvas id="Wak_CanvasID' + this.ID + '" width="50" height="50"></canvas>' );
		
		var Wak_Element = document.getElementById('Wak_CanvasID' + this.ID);
		var Wak_Context = Wak_Element.getContext('2d');
		
		Wak_Element.style.backgroundColor = BaseColor; // 背景色
		
		Wak_Context.strokeStyle = 'rgb(0,0,0)';  //線の色
		Wak_Context.lineWidth = this.ToplineWidth;
		Wak_Context.strokeRect( 0 , 0 ,     Wak_Element.getBoundingClientRect().width  , 0 ); // 上の線
		Wak_Context.lineWidth = this.LeftlineWidth;
		Wak_Context.strokeRect( 0 , 0 , 0 , Wak_Element.getBoundingClientRect().height     ); // 左の線
		Wak_Context.fillStyle = 'rgb(0,0,0)'; // 文字色
		Wak_Context.font = '20px serif';
		Wak_Context.fillText( this.MsgStr , 0, 20);
		
		// マウスを重ねると色が変わる
		Wak_Element.addEventListener( 'mouseover' , function (event) {
			event.target.style.backgroundColor = 'rgb(127, 255, 127)';
		} , false );
		
		// マウスを外すと色が戻る
		Wak_Element.addEventListener( 'mouseout'  , function (event) {
			
			                          event.target.style.backgroundColor = ColorControl.GetProgressColorStr( 'rgb(127, 255, 127)' , BaseColor , (1/4) , 'Wrk_Color2RGB_CanvasID' ) ;           // 1/4
			setTimeout( function () { event.target.style.backgroundColor = ColorControl.GetProgressColorStr( 'rgb(127, 255, 127)' , BaseColor , (2/4) , 'Wrk_Color2RGB_CanvasID' ) ; } , 100); // 2/4
			setTimeout( function () { event.target.style.backgroundColor = ColorControl.GetProgressColorStr( 'rgb(127, 255, 127)' , BaseColor , (3/4) , 'Wrk_Color2RGB_CanvasID' ) ; } , 200); // 3/4
			setTimeout( function () { event.target.style.backgroundColor = BaseColor                                                                                               ; } , 300); // 4/4
			
		} , false );
		
	}
}

// 今日の日付を取得
var ToDay     = new Date();
var TargetDay = new Date(ToDay);

// 今日の先頭日付を取得
TargetDay.setDate( TargetDay.getDate() - TargetDay.getDay() ); // 0:日曜日 6:土曜日

var DayArrObj = [];
for( IdxY = 1; IdxY <= 30 ; IdxY++ ) {
	
	// 左側の月表示用Canvas生成
	document.write( '<canvas id="Wak_CanvasML' + IdxY + '" width="50" height="50"></canvas>' );
	var Wak_Element = document.getElementById('Wak_CanvasML' + IdxY);
	//Wak_Element.style.backgroundColor = 'rgb(255,255,255)'; // 背景色
	
	// 月が変わった場合
	if( TargetDay.getDate() <= 7 ) {
		// 「〇月」を表示
		ViewDisplayTuki( Wak_Element , ( TargetDay.getMonth() + 1 ) + '月' );
	}
	
	// 一週間分表示
	for( IdxX = 1; IdxX <= 7 ; IdxX++ ) {
		
		var WrkDayObj = new OneDay_Cls();
		
		WrkDayObj.ID        = TargetDay;
		WrkDayObj.MsgStr    = TargetDay.getDate();
		if( TargetDay.getDate() == 1 && IdxX != 1 ) {
			// 1日の場合 上/左 の線を太く(日曜日除く)
			WrkDayObj.ToplineWidth  = 3;
			WrkDayObj.LeftlineWidth = 3;
		} else if( TargetDay.getDate() <= 7 ) {
			// 月の変わり目は上の線を太く
			WrkDayObj.ToplineWidth  = 3;
			WrkDayObj.LeftlineWidth = 1;
		} else {
			// 通常日の線は細く
			WrkDayObj.ToplineWidth  = 1;
			WrkDayObj.LeftlineWidth = 1;
		}
		WrkDayObj.MsgOut( GetDayColor( TargetDay , ToDay ) );
		
		DayArrObj.push( WrkDayObj );
		
		TargetDay.setDate( TargetDay.getDate() + 1 );
	}
	
	// 右側の月表示用Canvas生成
	document.write( '<canvas id="Wak_CanvasMR' + IdxY + '" width="50" height="50"></canvas>' );
	var Wak_Element = document.getElementById('Wak_CanvasMR' + IdxY);
	//Wak_Element.style.backgroundColor = 'rgb(255,255,255)'; // 背景色
	
	// 月が変わった場合
	if( TargetDay.getDate() >= 2 && TargetDay.getDate() <= 8 ) {
		// 「〇月」を表示
		ViewDisplayTuki( Wak_Element , ( TargetDay.getMonth() + 1 ) + '月' );
	}
	
	document.write( '<br>' );
	
}

// 「〇月」を表示
function ViewDisplayTuki( Wak_Element , MsgString ) {
	
	var Wak_Context = Wak_Element.getContext('2d');
	
	Wak_Context.strokeStyle = 'rgb(0,0,0)';  //線の色
	Wak_Context.lineWidth = 3;
	Wak_Context.strokeRect(0, 0, Wak_Element.getBoundingClientRect().width ,0 );
	
	// 「○月」を表示
	Wak_Context.fillStyle = 'rgb(0,0,0)'; // 文字色
	Wak_Context.font = '20px serif';
	Wak_Context.fillText( MsgString , 0, 20);
	
}

// 背景色取得
function GetDayColor( WTargetDay , WToDay ) {
	
	// 当日の色
	if( WTargetDay.toLocaleDateString()  == WToDay.toLocaleDateString() ) {
		return 'rgb(255,255,0)';
	}
	
	// 曜日毎に変更
	switch( WTargetDay.getDay() ) { // 0:日曜日 6:土曜日
	case 0:
	case 6:
		return 'rgb(255,128,128)';
	default:
		return 'rgb(255,255,255)';
	}
}

