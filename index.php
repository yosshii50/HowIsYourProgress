<html>
<meta http-equiv="content-type" charset="utf-8">
<head>
<title>進捗どうですか？</title>
</head>
<body>

スケジュール <a href="ScheduleAdd.html">追加</a> / <a href="ScheduleList.html">一覧(修正/削除)</a>


<canvas id="Wrk_Color2RGB_CanvasID" width="1" height="1" style="display:none;"></canvas><br>
<script language="JavaScript" src="ColorControl_Cls.js"></script>

<script language="JavaScript">
	class HogeHoge {
		
		MsgOut( ID , MsgStr , BaseColor ) {
			
			var ColorControl = new ColorControl_Cls();
			
			document.write( '<canvas id="Wak_CanvasID' + ID + '" width="50" height="50"></canvas>' );
			
			var Wak_Element = document.getElementById('Wak_CanvasID' + ID);
			var Wak_Context = Wak_Element.getContext('2d');
			
			Wak_Element.style.backgroundColor = BaseColor; // 背景色
			
			Wak_Context.strokeStyle = 'rgb(0,0,0)';  //線の色
			Wak_Context.strokeRect( 0 , 0 ,     Wak_Element.getBoundingClientRect().width  , 0 ); // 上の線
			Wak_Context.strokeRect( 0 , 0 , 0 , Wak_Element.getBoundingClientRect().height     ); // 左の線
			Wak_Context.fillStyle = 'rgb(0,0,0)'; // 文字色
			Wak_Context.font = '20px serif';
			Wak_Context.fillText( MsgStr , 0, 20);
			
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
	
	var HogeObj = [];
	for( IdxY = 1; IdxY <= 30 ; IdxY++ ) {
		
		// 左側の月表示用Canvas生成
		document.write( '<canvas id="Wak_CanvasML' + IdxY + '" width="50" height="50"></canvas>' );
		var Wak_Element = document.getElementById('Wak_CanvasML' + IdxY);
		Wak_Element.style.backgroundColor = 'rgb(255,255,255)'; // 背景色
		
		// 月が変わった場合
		if( TargetDay.getDate() <= 7 ) {
			// 「〇月」を表示
			ViewDisplayTuki( Wak_Element , ( TargetDay.getMonth() + 1 ) + '月' );
		}
		
		// 一週間分表示
		for( IdxX = 1; IdxX <= 7 ; IdxX++ ) {
			
			HogeObj.push( new HogeHoge() );
			HogeObj[HogeObj.length - 1].MsgOut( TargetDay , TargetDay.getDate() , GetDayColor( TargetDay , ToDay ) );
			
			TargetDay.setDate( TargetDay.getDate() + 1 );
		}
		
		// 右側の月表示用Canvas生成
		document.write( '<canvas id="Wak_CanvasMR' + IdxY + '" width="50" height="50"></canvas>' );
		var Wak_Element = document.getElementById('Wak_CanvasMR' + IdxY);
		Wak_Element.style.backgroundColor = 'rgb(255,255,255)'; // 背景色
		
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
	
</script>
</body>
</html>
