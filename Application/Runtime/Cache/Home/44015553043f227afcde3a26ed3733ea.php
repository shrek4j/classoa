<?php if (!defined('THINK_PATH')) exit();?> <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        .defaultClassDiv{
            background:#72CFD7;
            color:#FFF;
            position:absolute;
            border:solid white 2px;
            font-size:6px;
            font-family:Arial;
            text-align:center;
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
            var bottom = $("#"+div_end_<?php echo ($key); ?>).offset().top;
            var left = $("#"+div_start_<?php echo ($key); ?>).offset().left + border/2;//修正位置
            var width = default_width;
            var height = bottom - top - 2*border;//修正位置
            
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
            var div=$('<div class="defaultClassDiv" data-options="onStopDrag:onStopDrag,onStopResize:onStopResize" onmouseover="mouseover(this);">'+classType + '<br><a href="#" style="color: white">more...</a></div>');        //创建一个div
            div.attr('id',id);        //给div设置id
            div.attr('dayOfWeek',dayOfWeek);
            div.attr('startTime',startTime);
            div.attr('endTime',endTime);
            div.css({'top':top,'left':left});
            div.css({'height':height,'width':width});
            $("#divIncluder").append(div);
            
            $(div).draggable();
            $(div).resizable({
                handles:'s'
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
                            '1730','1800','1830','1900','1930','2000','2030','2100'];
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
                    alert(msg);
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
            $("#"+currId).css({'height':newHeight});
            
            
            //1.计算结束时间
            var newEndTime;
            var startTime = $("#"+currId).attr('startTime');
            for(var i=0;i<timeOfDay.length;i++){
                if(timeOfDay[i] == startTime){
                    if(i+timeUnit < timeOfDay.length){
                        newEndTime = timeOfDay[i+timeUnit];
                    }
                }
            }
            //2.更新实际值
            if(newEndTime != undefined){
                $("#"+currId).attr('endTime',newEndTime);
            }
        }
        //课程div resize事件  end
    </script>
    </head>
    <body>
        <div id="divIncluder">
        </div>
        <div class="right">
        <table align="center" rules="all" 
         style="font-family: David; font-size: large; border: 2px solid black; height:700px;text-align:center">
            <tr></tr>
                <td width="80px"></td><td width="80px" id="1_">Mon</td><td width="80px" id="2_">Tus</td><td width="80px" id="3_">Wen</td><td width="80px" id="4_">Thu</td><td width="80px" id="5_">Fri</td><td width="80px" id="6_">Sat</td><td width="80px" id="7_">Sun</td>
            </tr>
            <tr>
              <td>07:30</td><td id="1_0730"></td><td id="2_0730"></td><td id="3_0730"></td><td id="4_0730"></td><td id="5_0730"></td><td id="6_0730"></td><td id="7_0730"></td>
            </tr>
            <tr>
              <td>08:00</td><td id="1_0800"></td><td id="2_0800"></td><td id="3_0800"></td><td id="4_0800"></td><td id="5_0800"></td><td id="6_0800"></td><td id="7_0800"></td>
            </tr>
             <tr>
              <td>08:30</td><td id="1_0830"></td><td id="2_0830"></td><td id="3_0830"></td><td id="4_0830"></td><td id="5_0830"></td><td id="6_0830"></td><td id="7_0830"></td>
            </tr>
            <tr>
              <td>09:00</td><td id="1_0900"></td><td id="2_0900"></td><td id="3_0900"></td><td id="4_0900"></td><td id="5_0900"></td><td id="6_0900"></td><td id="7_0900"></td>
            </tr>
            <tr>
              <td>09:30</td><td id="1_0930"></td><td id="2_0930"></td><td id="3_0930"></td><td id="4_0930"></td><td id="5_0930"></td><td id="6_0930"></td><td id="7_0930"></td>
            </tr>
            <tr>
              <td>10:00</td><td id="1_1000"></td><td id="2_1000"></td><td id="3_1000"></td><td id="4_1000"></td><td id="5_1000"></td><td id="6_1000"></td><td id="7_1000"></td>
            </tr>
            <tr>
              <td>10:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>11:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>11:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>12:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>12:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>13:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>13:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>14:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>14:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>15:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>15:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>16:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>16:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>17:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>17:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>18:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>18:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>19:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>19:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>20:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>20:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>21:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
        </table>
        </div>
    </body>
 </html>