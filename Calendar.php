<?php

// カレンダー表示

print( 'class OneDay_Cls {' );
print( '	' );
print( '	MsgOut( BaseColor ) {' );
print( '		' );
print( '		var ColorControl = new ColorControl_Cls();' );
print( '		' );
print( '		document.write( \'<canvas id="Wak_CanvasID\' + this.ID + \'" width="50" height="50"></canvas>\' );' );
print( '		' );
print( '		var Wak_Element = document.getElementById(\'Wak_CanvasID\' + this.ID);' );
print( '		var Wak_Context = Wak_Element.getContext(\'2d\');' );
print( '		' );
print( '		Wak_Element.style.backgroundColor = BaseColor;' ); // 背景色
print( '		' );
print( '		Wak_Context.strokeStyle = \'rgb(0,0,0)\';' );  //線の色
print( '		Wak_Context.lineWidth = this.ToplineWidth;' );
print( '		Wak_Context.strokeRect( 0 , 0 ,     Wak_Element.getBoundingClientRect().width  , 0 );' ); // 上の線
print( '		Wak_Context.lineWidth = this.LeftlineWidth;' );
print( '		Wak_Context.strokeRect( 0 , 0 , 0 , Wak_Element.getBoundingClientRect().height     );' ); // 左の線
print( '		Wak_Context.fillStyle = \'rgb(0,0,0)\';' ); // 文字色
print( '		Wak_Context.font = \'20px serif\';' );
print( '		Wak_Context.fillText( this.MsgStr , 0, 20);' );
print( '		' );
print( '		' ); // マウスを重ねると色が変わる
print( '		Wak_Element.addEventListener( \'mouseover\' , function (event) {' );
print( '			event.target.style.backgroundColor = \'rgb(127, 255, 127)\';' );
print( '		} , false );' );
print( '		' );
print( '		' ); // マウスを外すと色が戻る
print( '		Wak_Element.addEventListener( \'mouseout\'  , function (event) {' );
print( '			' );
print( '			                          event.target.style.backgroundColor = ColorControl.GetProgressColorStr( \'rgb(127, 255, 127)\' , BaseColor , (1/4) , \'Wrk_Color2RGB_CanvasID\' ) ;          ' ); // 1/4
print( '			setTimeout( function () { event.target.style.backgroundColor = ColorControl.GetProgressColorStr( \'rgb(127, 255, 127)\' , BaseColor , (2/4) , \'Wrk_Color2RGB_CanvasID\' ) ; } , 100);' ); // 2/4
print( '			setTimeout( function () { event.target.style.backgroundColor = ColorControl.GetProgressColorStr( \'rgb(127, 255, 127)\' , BaseColor , (3/4) , \'Wrk_Color2RGB_CanvasID\' ) ; } , 200);' ); // 3/4
print( '			setTimeout( function () { event.target.style.backgroundColor = BaseColor                                                                                                   ; } , 300);' ); // 4/4
print( '			' );
print( '		} , false );' );
print( '		' );
print( '	}' );
print( '}' );

// 今日の日付を取得
print( 'var ToDay     = new Date();' );
print( 'var TargetDay = new Date(ToDay);' );


// 今日の先頭日付を取得
print( 'TargetDay.setDate( TargetDay.getDate() - TargetDay.getDay() );' ); // 0:日曜日 6:土曜日

print( 'var DayArrObj = [];' );
print( 'for( IdxY = 1; IdxY <= 30 ; IdxY++ ) {' );
print( '	' );
print( '	' ); // 左側の月表示用Canvas生成
print( '	document.write( \'<canvas id="Wak_CanvasML\' + IdxY + \'" width="50" height="50"></canvas>\' );' );
print( '	var Wak_Element = document.getElementById(\'Wak_CanvasML\' + IdxY);' );
//print( '	Wak_Element.style.backgroundColor = \'rgb(255,255,255)\';' ); // 背景色
print( '	' );
print( '	' ); // 月が変わった場合
print( '	if( TargetDay.getDate() <= 7 ) {' );
print( '		' ); // 「〇月」を表示
print( '		ViewDisplayTuki( Wak_Element , ( TargetDay.getMonth() + 1 ) + \'月\' );' );
print( '	}' );
print( '	' );
print( '	' ); // 一週間分表示
print( '	for( IdxX = 1; IdxX <= 7 ; IdxX++ ) {' );
print( '		' );
print( '		var WrkDayObj = new OneDay_Cls();' );
print( '		' );
print( '		WrkDayObj.ID        = TargetDay;' );
print( '		WrkDayObj.MsgStr    = TargetDay.getDate();' );
print( '		if( TargetDay.getDate() == 1 && IdxX != 1 ) {' );
print( '			' ); // 1日の場合 上/左 の線を太く(日曜日除く)
print( '			WrkDayObj.ToplineWidth  = 3;' );
print( '			WrkDayObj.LeftlineWidth = 3;' );
print( '		} else if( TargetDay.getDate() <= 7 ) {' );
print( '			' ); // 月の変わり目は上の線を太く
print( '			WrkDayObj.ToplineWidth  = 3;' );
print( '			WrkDayObj.LeftlineWidth = 1;' );
print( '		} else {' );
print( '			' ); // 通常日の線は細く
print( '			WrkDayObj.ToplineWidth  = 1;' );
print( '			WrkDayObj.LeftlineWidth = 1;' );
print( '		}' );
print( '		WrkDayObj.MsgOut( GetDayColor( TargetDay , ToDay ) );' );
print( '		' );
print( '		DayArrObj.push( WrkDayObj );' );
print( '		' );
print( '		TargetDay.setDate( TargetDay.getDate() + 1 );' );
print( '	}' );
print( '	' );
print( '	' ); // 右側の月表示用Canvas生成
print( '	document.write( \'<canvas id="Wak_CanvasMR\' + IdxY + \'" width="50" height="50"></canvas>\' );' );
print( '	var Wak_Element = document.getElementById(\'Wak_CanvasMR\' + IdxY);' );
// print( '	Wak_Element.style.backgroundColor = \'rgb(255,255,255)\'; ' ); // 背景色
print( '	' );
print( '	' ); // 月が変わった場合
print( '	if( TargetDay.getDate() >= 2 && TargetDay.getDate() <= 8 ) {' );
print( '		' ); // 「〇月」を表示
print( '		ViewDisplayTuki( Wak_Element , ( TargetDay.getMonth() + 1 ) + \'月\' );' );
print( '	}' );
print( '	' );
print( '	document.write( \'<br>\' );' );
print( '	' );
print( '}' );

// 「〇月」を表示
print( 'function ViewDisplayTuki( Wak_Element , MsgString ) {' );
print( '	' );
print( '	var Wak_Context = Wak_Element.getContext(\'2d\');' );
print( '	' );
print( '	Wak_Context.strokeStyle = \'rgb(0,0,0)\';' ); //線の色
print( '	Wak_Context.lineWidth = 3;' );
print( '	Wak_Context.strokeRect(0, 0, Wak_Element.getBoundingClientRect().width ,0 );' );
print( '	' );
print( '	' ); // 「○月」を表示
print( '	Wak_Context.fillStyle = \'rgb(0,0,0)\';' ); // 文字色
print( '	Wak_Context.font = \'20px serif\';' );
print( '	Wak_Context.fillText( MsgString , 0, 20);' );
print( '	' );
print( '}' );

// 背景色取得
print( 'function GetDayColor( WTargetDay , WToDay ) {' );
print( '	' );
print( '	' ); // 当日の色
print( '	if( WTargetDay.toLocaleDateString()  == WToDay.toLocaleDateString() ) {' );
print( '		return \'rgb(255,255,0)\';' );
print( '	}' );
print( '	' );
print( '	' ); // 曜日毎に変更
print( '	switch( WTargetDay.getDay() ) {' ); // 0:日曜日 6:土曜日
print( '	case 0:' );
print( '	case 6:' );
print( '		return \'rgb(255,128,128)\';' );
print( '	default:' );
print( '		return \'rgb(255,255,255)\';' );
print( '	}' );
print( '}' );


?>

