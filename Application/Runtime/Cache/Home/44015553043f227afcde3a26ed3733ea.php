<?php if (!defined('THINK_PATH')) exit();?> <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        .defaultClassDiv{
            background:#70E1EF;
            color:#FFF;
            position:absolute;
            border:solid #CBF3FB 2px;
            font-size:6px;
            font-family:Arial;
            text-align:center;
            opacity:0.9;
        }
    
        .singleTdTop{
            border-width: 1px 0px 0px 0px;border-color: black; border-style:dashed solid solid solid;
        }
        .singleTdTopAndLeft{
            border-width: 1px 0px 0px 1px;border-color: black; border-style:dashed solid solid solid;
        }
        
        .doubleTdTop{
            border-width: 1px 0px 0px 0px;border-color: black; border-style:solid solid solid solid;
        }
        
        .doubleTdTopAndLeft{
            border-width: 1px 0px 0px 1px;border-color: black; border-style:solid solid solid solid;
        }
        
        .topTdLeft{
            border-width: 0px 0px 0px 1px;border-color: black; border-style:solid solid solid solid;
        }
    </style>
        <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
  <!--  <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css"> -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    
    <script type="text/javascript">
        var default_width = '78px';//单元格width=80,div设成78，有2px是border的
        var default_height = 24;//单元格的height
        var border = 2;//单元格的border
        
        //打开页面时，加载课程div，只运行一次
        $(function(){
            <?php if(is_array($scheduleList)): foreach($scheduleList as $key=>$vo): ?>var div_start_<?php echo ($key); ?> = '<?php echo ($vo["day_of_week"]); ?>_<?php echo ($vo["start_time"]); ?>';
            var div_end_<?php echo ($key); ?> = '<?php echo ($vo["day_of_week"]); ?>_<?php echo ($vo["end_time"]); ?>';
            
            var top = $("#"+div_start_<?php echo ($key); ?>).offset().top + border/2;//修正位置
           // var bottom = $("#"+div_end_<?php echo ($key); ?>).offset().top;
            var left = $("#"+div_start_<?php echo ($key); ?>).offset().left + border/2;//修正位置
            var width = default_width;
           // var height = bottom - top - 2*border;//修正位置
            var timeUnit;
            for(var i=0;i<timeOfDay.length;i++){
                if(timeOfDay[i] == '<?php echo ($vo["start_time"]); ?>'){
                    timeUnit = i;
                }
                if(timeOfDay[i] == '<?php echo ($vo["end_time"]); ?>'){
                    timeUnit = i - timeUnit;
                }
            }
            var height = timeUnit * default_height - 5;
            
            var id = '<?php echo ($vo["schedule_id"]); ?>';
            var dayOfWeek = '<?php echo ($vo["day_of_week"]); ?>';
            var startTime = '<?php echo ($vo["start_time"]); ?>';
            var endTime = '<?php echo ($vo["end_time"]); ?>';
            var classType = '<?php echo ($vo["class_type"]); ?>';
            var studNames = '<?php echo ($vo["name"]); ?>';
            
            createDiv(id,dayOfWeek,startTime,endTime,top,height,left,width,classType,studNames);<?php endforeach; endif; ?>
         });

        //创建一个课程div
        function createDiv(id,dayOfWeek,startTime,endTime,top,height,left,width,classType,studNames){
            var div=$('<div class="defaultClassDiv" data-options="handle:\'#'+id+'\',onStopDrag:onStopDrag,onStopResize:onStopResize" onmouseover="mouseover(this);">' +
                        '<div id="'+id+'" style="padding:4px;background:#065FB9;color:#fff;font-family:Arial;">'+classType+'</div>' +
                        '<a href="#" style="color: white">more...</a></div>');        //创建一个div
            div.attr('id',id);        //给div设置id
            div.attr('dayOfWeek',dayOfWeek);
            div.attr('startTime',startTime);
            div.attr('endTime',endTime);
            div.css({'top':top,'left':left});
            div.css({'height':height,'width':width});
            $("#divIncluder").append(div);
            
            $(div).draggable();
            $(div).resizable({
                handles:'s',
                edge:15
            });
                    
        }
        </script>
        
        <script type="text/javascript">
            //获得当前操作div的id
            var currId;
            function mouseover(div){
                currId = div.id;
            }
        </script>
        
        <script type="text/javascript">
        //课程div拖动事件 start

        var dayOfWeek = ['1','2','3','4','5','6','7'];
        var timeOfDay = ['0730','0800','0830','0900','0930','1000','1030','1100','1130','1200','1230','1300','1330','1400','1430','1500','1530','1600','1630','1700',
                            '1730','1800','1830','1900','1930','2000','2030','2100','2130'];
        function onStopDrag(e){
            var d = e.data;
            
            //修正课程div的位置 start
            //1.得到最新的top,left
            var shortestDis = 10000;
            var fitLeft;
            var fitTop;
            var fitStartEle;
            for(var i=0;i<dayOfWeek.length;i++){
                for(var m=0;m<timeOfDay.length;m++){
                    var ele = $("#"+dayOfWeek[i]+"_"+timeOfDay[m]);
                    if(ele[0] != undefined){
                       var width = ele.offset().left - d.left;
                        var height = ele.offset().top - d.top;
                        var dis = Math.sqrt(Math.pow(width,2)+Math.pow(height,2));
                        if(dis < shortestDis){
                            shortestDis = dis;
                            fitLeft = ele.offset().left + border/2;//修正位置
                            fitTop = ele.offset().top + border/2;//修正位置
                            fitStartEle = ele;
                        }
                    }
                }
            }
            //2.更新
            $("#"+currId).css({'top':fitTop,'left':fitLeft});
            //修正课程div的位置 end  
          
          
            //修改当前课程div的dayOfWeek,startTime,endTime   start
            //1.得到最新的dayOfWeek,得到最新的startTime,得到最新的endTime
            var fitStartId = fitStartEle.attr('id');
            var newDayOfWeek = fitStartId.split('_')[0];
            var newStartTime = fitStartId.split('_')[1];
            var newEndTime;
            var timeUnit = ($("#"+currId).height() + 5)/default_height;//3是什么？
            for(var i=0;i<timeOfDay.length;i++){
                if(timeOfDay[i] == newStartTime){
                    if(i+timeUnit < timeOfDay.length){
                        newEndTime = timeOfDay[i+timeUnit];
                        break;
                    }
                }
            }
            //2.更新
            if(newEndTime != undefined){
                $("#"+currId).attr('dayOfWeek',newDayOfWeek);
                $("#"+currId).attr('startTime',newStartTime);
                $("#"+currId).attr('endTime',newEndTime);
            }
            //修改当前课程div的dayOfWeek,startTime,endTime   end
          
            //保存数据
            $.ajax({
               type: "POST",
               url: "saveSchedule",
               data: "schedId="+currId+"&dayOfWeek="+newDayOfWeek+"&startTime="+newStartTime+"&endTime="+newEndTime,
               success: function(msg){
                   
               }
            });
          
        }
        //课程div拖动事件 end
     </script>

    <script type="text/javascript">
        //课程div resize事件  start
        function onStopResize(e){
            //1.自动对齐UI
            var timeUnit;
            //差值
            var diff = ($("#"+currId).height() + 5) % default_height;
            if(diff*2 > default_height){
                timeUnit = (($("#"+currId).height() + 5 - diff) / default_height) + 1;
            }else{
                timeUnit = ($("#"+currId).height() + 5 - diff) / default_height;
            }
            
            //2.更新UI高度
            var newHeight = timeUnit * default_height - 5;
            var left = $("#"+currId).offset().left;
            $("#"+currId).css({'height':newHeight,'left':left});
            
            
            //1.计算结束时间
            var newEndTime;
            var startTime = $("#"+currId).attr('startTime');
            for(var i=0;i<timeOfDay.length;i++){
                if(timeOfDay[i] == startTime){
                    if(i+timeUnit < timeOfDay.length){
                        newEndTime = timeOfDay[i+timeUnit];
                        break;
                    }
                }
            }
            //2.更新实际值
            if(newEndTime != undefined){
                $("#"+currId).attr('endTime',newEndTime);
            }
            
            var newDayOfWeek = $("#"+currId).attr('dayOfWeek');
            var newStartTime = $("#"+currId).attr('startTime');
            var newEndTime = $("#"+currId).attr('endTime');
            
            //保存数据
            $.ajax({
               type: "POST",
               url: "saveSchedule",
               data: "schedId="+currId+"&dayOfWeek="+newDayOfWeek+"&startTime="+newStartTime+"&endTime="+newEndTime,
               success: function(msg){
                   
               }
            });
        }
        //课程div resize事件  end
    </script>
    
    <script type="text/javascript">
        $(function(){
            $('.right td').dblclick(
                function () { 
                    alert($(this).height()); 
                }
            );
        });
    </script>
    </head>
    <body style="background: #CBF3FB;">
        <div id="divIncluder">
        </div>
        <div class="right">
        <table align="center"
         style="background:#FFF7A9;font-family:Arial,'黑体'; font-size: middle; border: 2px solid black; height:700px;text-align:center">
            <tr></tr>
                <td width="80px"></td><td width="80px" id="1_" class="topTdLeft">星期一</td><td width="80px" id="2_"class="topTdLeft">星期二</td><td width="80px" id="3_"class="topTdLeft">星期三</td><td width="80px" id="4_"class="topTdLeft">星期四</td><td width="80px" id="5_"class="topTdLeft">星期五</td><td width="80px" id="6_"class="topTdLeft">星期六</td><td width="80px" id="7_"class="topTdLeft">星期日</td>
            </tr>
            <tr>
              <td class="singleTdTop">07:30</td><td id="1_0730" class="singleTdTopAndLeft"></td><td id="2_0730" class="singleTdTopAndLeft"></td><td id="3_0730" class="singleTdTopAndLeft"></td><td id="4_0730" class="singleTdTopAndLeft"></td><td id="5_0730" class="singleTdTopAndLeft"></td><td id="6_0730" class="singleTdTopAndLeft"></td><td id="7_0730" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop"><b>08:00</b></td><td id="1_0800" class="doubleTdTopAndLeft"></td><td id="2_0800" class="doubleTdTopAndLeft"></td><td id="3_0800" class="doubleTdTopAndLeft"></td><td id="4_0800" class="doubleTdTopAndLeft"></td><td id="5_0800" class="doubleTdTopAndLeft"></td><td id="6_0800" class="doubleTdTopAndLeft"></td><td id="7_0800" class="doubleTdTopAndLeft"></td>
            </tr>
             <tr>
              <td class="singleTdTop">08:30</td><td id="1_0830" class="singleTdTopAndLeft"></td><td id="2_0830" class="singleTdTopAndLeft"></td><td id="3_0830" class="singleTdTopAndLeft"></td><td id="4_0830" class="singleTdTopAndLeft"></td><td id="5_0830" class="singleTdTopAndLeft"></td><td id="6_0830" class="singleTdTopAndLeft"></td><td id="7_0830" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">09:00</td><td id="1_0900" class="doubleTdTopAndLeft"></td><td id="2_0900" class="doubleTdTopAndLeft"></td><td id="3_0900" class="doubleTdTopAndLeft"></td><td id="4_0900" class="doubleTdTopAndLeft"></td><td id="5_0900" class="doubleTdTopAndLeft"></td><td id="6_0900" class="doubleTdTopAndLeft"></td><td id="7_0900" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">09:30</td><td id="1_0930" class="singleTdTopAndLeft"></td><td id="2_0930" class="singleTdTopAndLeft"></td><td id="3_0930" class="singleTdTopAndLeft"></td><td id="4_0930" class="singleTdTopAndLeft"></td><td id="5_0930" class="singleTdTopAndLeft"></td><td id="6_0930" class="singleTdTopAndLeft"></td><td id="7_0930" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">10:00</td><td id="1_1000" class="doubleTdTopAndLeft"></td><td id="2_1000" class="doubleTdTopAndLeft"></td><td id="3_1000" class="doubleTdTopAndLeft"></td><td id="4_1000" class="doubleTdTopAndLeft"></td><td id="5_1000" class="doubleTdTopAndLeft"></td><td id="6_1000" class="doubleTdTopAndLeft"></td><td id="7_1000" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">10:30</td><td id="1_1030" class="singleTdTopAndLeft"></td><td id="2_1030" class="singleTdTopAndLeft"></td><td id="3_1030" class="singleTdTopAndLeft"></td><td id="4_1030" class="singleTdTopAndLeft"></td><td id="5_1030" class="singleTdTopAndLeft"></td><td id="6_1030" class="singleTdTopAndLeft"></td><td id="7_1030" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">11:00</td><td id="1_1100" class="doubleTdTopAndLeft"></td><td id="2_1100" class="doubleTdTopAndLeft"></td><td id="3_1100" class="doubleTdTopAndLeft"></td><td id="4_1100" class="doubleTdTopAndLeft"></td><td id="5_1100" class="doubleTdTopAndLeft"></td><td id="6_1100" class="doubleTdTopAndLeft"></td><td id="7_1100" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">11:30</td><td id="1_1130" class="singleTdTopAndLeft"></td><td id="2_1130" class="singleTdTopAndLeft"></td><td id="3_1130" class="singleTdTopAndLeft"></td><td id="4_1130" class="singleTdTopAndLeft"></td><td id="5_1130" class="singleTdTopAndLeft"></td><td id="6_1130" class="singleTdTopAndLeft"></td><td id="7_1130" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop"><b>12:00</b></td><td id="1_1200" class="doubleTdTopAndLeft"></td><td id="2_1200" class="doubleTdTopAndLeft"></td><td id="3_1200" class="doubleTdTopAndLeft"></td><td id="4_1200" class="doubleTdTopAndLeft"></td><td id="5_1200" class="doubleTdTopAndLeft"></td><td id="6_1200" class="doubleTdTopAndLeft"></td><td id="7_1200" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">12:30</td><td id="1_1230" class="singleTdTopAndLeft"></td><td id="2_1230" class="singleTdTopAndLeft"></td><td id="3_1230" class="singleTdTopAndLeft"></td><td id="4_1230" class="singleTdTopAndLeft"></td><td id="5_1230" class="singleTdTopAndLeft"></td><td id="6_1230" class="singleTdTopAndLeft"></td><td id="7_1230" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">13:00</td><td id="1_1300" class="doubleTdTopAndLeft"></td><td id="2_1300" class="doubleTdTopAndLeft"></td><td id="3_1300" class="doubleTdTopAndLeft"></td><td id="4_1300" class="doubleTdTopAndLeft"></td><td id="5_1300" class="doubleTdTopAndLeft"></td><td id="6_1300" class="doubleTdTopAndLeft"></td><td id="7_1300" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">13:30</td><td id="1_1330" class="singleTdTopAndLeft"></td><td id="2_1330" class="singleTdTopAndLeft"></td><td id="3_1330" class="singleTdTopAndLeft"></td><td id="4_1330" class="singleTdTopAndLeft"></td><td id="5_1330" class="singleTdTopAndLeft"></td><td id="6_1330" class="singleTdTopAndLeft"></td><td id="7_1330" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">14:00</td><td id="1_1400" class="doubleTdTopAndLeft"></td><td id="2_1400" class="doubleTdTopAndLeft"></td><td id="3_1400" class="doubleTdTopAndLeft"></td><td id="4_1400" class="doubleTdTopAndLeft"></td><td id="5_1400" class="doubleTdTopAndLeft"></td><td id="6_1400" class="doubleTdTopAndLeft"></td><td id="7_1400" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">14:30</td><td id="1_1430" class="singleTdTopAndLeft"></td><td id="2_1430" class="singleTdTopAndLeft"></td><td id="3_1430" class="singleTdTopAndLeft"></td><td id="4_1430" class="singleTdTopAndLeft"></td><td id="5_1430" class="singleTdTopAndLeft"></td><td id="6_1430" class="singleTdTopAndLeft"></td><td id="7_1430" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">15:00</td><td id="1_1500" class="doubleTdTopAndLeft"></td><td id="2_1500" class="doubleTdTopAndLeft"></td><td id="3_1500" class="doubleTdTopAndLeft"></td><td id="4_1500" class="doubleTdTopAndLeft"></td><td id="5_1500" class="doubleTdTopAndLeft"></td><td id="6_1500" class="doubleTdTopAndLeft"></td><td id="7_1500" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">15:30</td><td id="1_1530" class="singleTdTopAndLeft"></td><td id="2_1530" class="singleTdTopAndLeft"></td><td id="3_1530" class="singleTdTopAndLeft"></td><td id="4_1530" class="singleTdTopAndLeft"></td><td id="5_1530" class="singleTdTopAndLeft"></td><td id="6_1530" class="singleTdTopAndLeft"></td><td id="7_1530" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop"><b>16:00</b></td><td id="1_1600" class="doubleTdTopAndLeft"></td><td id="2_1600" class="doubleTdTopAndLeft"></td><td id="3_1600" class="doubleTdTopAndLeft"></td><td id="4_1600" class="doubleTdTopAndLeft"></td><td id="5_1600" class="doubleTdTopAndLeft"></td><td id="6_1600" class="doubleTdTopAndLeft"></td><td id="7_1600" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">16:30</td><td id="1_1630" class="singleTdTopAndLeft"></td><td id="2_1630" class="singleTdTopAndLeft"></td><td id="3_1630" class="singleTdTopAndLeft"></td><td id="4_1630" class="singleTdTopAndLeft"></td><td id="5_1630" class="singleTdTopAndLeft"></td><td id="6_1630" class="singleTdTopAndLeft"></td><td id="7_1630" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">17:00</td><td id="1_1700" class="doubleTdTopAndLeft"></td><td id="2_1700" class="doubleTdTopAndLeft"></td><td id="3_1700" class="doubleTdTopAndLeft"></td><td id="4_1700" class="doubleTdTopAndLeft"></td><td id="5_1700" class="doubleTdTopAndLeft"></td><td id="6_1700" class="doubleTdTopAndLeft"></td><td id="7_1700" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">17:30</td><td id="1_1730" class="singleTdTopAndLeft"></td><td id="2_1730" class="singleTdTopAndLeft"></td><td id="3_1730" class="singleTdTopAndLeft"></td><td id="4_1730" class="singleTdTopAndLeft"></td><td id="5_1730" class="singleTdTopAndLeft"></td><td id="6_1730" class="singleTdTopAndLeft"></td><td id="7_1730" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">18:00</td><td id="1_1800" class="doubleTdTopAndLeft"></td><td id="2_1800" class="doubleTdTopAndLeft"></td><td id="3_1800" class="doubleTdTopAndLeft"></td><td id="4_1800" class="doubleTdTopAndLeft"></td><td id="5_1800" class="doubleTdTopAndLeft"></td><td id="6_1800" class="doubleTdTopAndLeft"></td><td id="7_1800" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">18:30</td><td id="1_1830" class="singleTdTopAndLeft"></td><td id="2_1830" class="singleTdTopAndLeft"></td><td id="3_1830" class="singleTdTopAndLeft"></td><td id="4_1830" class="singleTdTopAndLeft"></td><td id="5_1830" class="singleTdTopAndLeft"></td><td id="6_1830" class="singleTdTopAndLeft"></td><td id="7_1830" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">19:00</td><td id="1_1900" class="doubleTdTopAndLeft"></td><td id="2_1900" class="doubleTdTopAndLeft"></td><td id="3_1900" class="doubleTdTopAndLeft"></td><td id="4_1900" class="doubleTdTopAndLeft"></td><td id="5_1900" class="doubleTdTopAndLeft"></td><td id="6_1900" class="doubleTdTopAndLeft"></td><td id="7_1900" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">19:30</td><td id="1_1930" class="singleTdTopAndLeft"></td><td id="2_1930" class="singleTdTopAndLeft"></td><td id="3_1930" class="singleTdTopAndLeft"></td><td id="4_1930" class="singleTdTopAndLeft"></td><td id="5_1930" class="singleTdTopAndLeft"></td><td id="6_1930" class="singleTdTopAndLeft"></td><td id="7_1930" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">20:00</td><td id="1_2000" class="doubleTdTopAndLeft"></td><td id="2_2000" class="doubleTdTopAndLeft"></td><td id="3_2000" class="doubleTdTopAndLeft"></td><td id="4_2000" class="doubleTdTopAndLeft"></td><td id="5_2000" class="doubleTdTopAndLeft"></td><td id="6_2000" class="doubleTdTopAndLeft"></td><td id="7_2000" class="doubleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="singleTdTop">20:30</td><td id="1_2030" class="singleTdTopAndLeft"></td><td id="2_2030" class="singleTdTopAndLeft"></td><td id="3_2030" class="singleTdTopAndLeft"></td><td id="4_2030" class="singleTdTopAndLeft"></td><td id="5_2030" class="singleTdTopAndLeft"></td><td id="6_2030" class="singleTdTopAndLeft"></td><td id="7_2030" class="singleTdTopAndLeft"></td>
            </tr>
            <tr>
              <td class="doubleTdTop">21:00</td><td id="1_2100" class="doubleTdTopAndLeft"></td><td id="2_2100" class="doubleTdTopAndLeft"></td><td id="3_2100" class="doubleTdTopAndLeft"></td><td id="4_2100" class="doubleTdTopAndLeft"></td><td id="5_2100" class="doubleTdTopAndLeft"></td><td id="6_2100" class="doubleTdTopAndLeft"></td><td id="7_2100" class="doubleTdTopAndLeft"></td>
            </tr>
        </table>
        </div>
    </body>
 </html>