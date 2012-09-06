scheduler.form_blocks.recurring={render:function(A){return scheduler.__recurring_template},set_value:function(L,K,P){var I={start:P.start_date,end:P._end_date};var E=scheduler.date.str_to_date(scheduler.config.repeat_date);var G=scheduler.date.date_to_str(scheduler.config.repeat_date);var F=L.getElementsByTagName("FORM")[0];var B=[];function H(S){for(var T=0;T<S.length;T++){var U=S[T];if(U.type=="checkbox"||U.type=="radio"){if(!B[U.name]){B[U.name]=[]}B[U.name].push(U)}else{B[U.name]=U}}}H(F.getElementsByTagName("INPUT"));H(F.getElementsByTagName("SELECT"));var C=function(S){return document.getElementById(S)};function O(T){var S=B[T];for(var U=0;U<S.length;U++){if(S[U].checked){return S[U].value}}}function J(){C("dhx_repeat_day").style.display="none";C("dhx_repeat_week").style.display="none";C("dhx_repeat_month").style.display="none";C("dhx_repeat_year").style.display="none";C("dhx_repeat_"+this.value).style.display="block"}function D(V){var T=[O("repeat")];Q[T[0]](T,V);while(T.length<5){T.push("")}var U="";if(B.end[0].checked){V.end=new Date(9999,1,1);U="no"}else{if(B.end[2].checked){V.end=E(B.date_of_end.value)}else{scheduler.transpose_type(T.join("_"));U=Math.max(1,B.occurences_count.value);var S=((T[0]=="week"&&T[4]&&T[4].toString().indexOf(scheduler.config.start_on_monday?1:0)==-1)?1:0);V.end=scheduler.date.add(new Date(V.start),U+S,T.join("_"))}}return T.join("_")+"#"+U}var Q={month:function(S,T){if(O("month_type")=="d"){S.push(Math.max(1,B.month_count.value));T.start.setDate(B.month_day.value)}else{S.push(Math.max(1,B.month_count2.value));S.push(B.month_day2.value);S.push(Math.max(1,B.month_week2.value));T.start.setDate(1)}T._start=true},week:function(V,W){V.push(Math.max(1,B.week_count.value));V.push("");V.push("");var U=[];var S=B.week_day;for(var T=0;T<S.length;T++){if(S[T].checked){U.push(S[T].value)}}if(!U.length){U.push(W.start.getDay())}W.start=scheduler.date.week_start(W.start);W._start=true;V.push(U.sort().join(","))},day:function(S){if(O("day_type")=="d"){S.push(Math.max(1,B.day_count.value))}else{S.push("week");S.push(1);S.push("");S.push("");S.push("1,2,3,4,5");S.splice(0,1)}},year:function(S,T){if(O("year_type")=="d"){S.push("1");T.start.setMonth(0);T.start.setDate(B.year_day.value);T.start.setMonth(B.year_month.value)}else{S.push("1");S.push(B.year_day2.value);S.push(B.year_week2.value);T.start.setDate(1);T.start.setMonth(B.year_month2.value)}T._start=true}};var M={week:function(V,W){B.week_count.value=V[1];var S=B.week_day;var U=V[4].split(",");var X={};for(var T=0;T<U.length;T++){X[U[T]]=true}for(var T=0;T<S.length;T++){S[T].checked=(!!X[S[T].value])}},month:function(S,T){if(S[2]==""){B.month_type[0].checked=true;B.month_count.value=S[1];B.month_day.value=T.start.getDate()}else{B.month_type[1].checked=true;B.month_count2.value=S[1];B.month_week2.value=S[3];B.month_day2.value=S[2]}},day:function(S,T){B.day_type[0].checked=true;B.day_count.value=S[1]},year:function(S,T){if(S[2]==""){B.year_type[0].checked=true;B.year_day.value=T.start.getDate();B.year_month.value=T.start.getMonth()}else{B.year_type[1].checked=true;B.year_week2.value=S[3];B.year_day2.value=S[2];B.year_month2.value=T.start.getMonth()}}};function R(S,V){var T=S.split("#");S=T[0].split("_");M[S[0]](S,V);var U=B.repeat[({day:0,week:1,month:2,year:3})[S[0]]];switch(T[1]){case"no":B.end[0].checked=true;break;case"":B.end[2].checked=true;B.date_of_end.value=G(V.end);break;default:B.end[1].checked=true;B.occurences_count.value=T[1];break}U.checked=true;U.onclick()}for(var N=0;N<F.elements.length;N++){var A=F.elements[N];switch(A.name){case"repeat":A.onclick=J;break}}scheduler.form_blocks.recurring.set_value=function(T,U,S){T.open=!S.rec_type;if(S.event_pid&&S.event_pid!="0"){T.blocked=true}else{T.blocked=false}I.start=S.start_date;I.end=S._end_date;scheduler.form_blocks.recurring.button_click(0,T.previousSibling.firstChild.firstChild,T,T);if(U){R(U,I)}};scheduler.form_blocks.recurring.get_value=function(T,S){if(T.open){S.rec_type=D(I);if(I._start){S._start_date=S.start_date=I.start;I._start=false}else{S._start_date=null}S._end_date=S.end_date=I.end;S.rec_pattern=S.rec_type.split("#")[0]}else{S.rec_type=S.rec_pattern="";S._end_date=S.end_date}return S.rec_type};scheduler.form_blocks.recurring.set_value(L,K,P)},get_value:function(B,A){},focus:function(A){},button_click:function(B,C,D,A){if(!A.open&&!A.blocked){A.style.height="115px";C.style.backgroundPosition="-5px 0px";C.nextSibling.innerHTML=scheduler.locale.labels.button_recurring_open}else{A.style.height="0px";C.style.backgroundPosition="-5px 20px";C.nextSibling.innerHTML=scheduler.locale.labels.button_recurring}A.open=!A.open;scheduler.setLightboxSize()}};scheduler._rec_markers={};scheduler._rec_markers_pull={};scheduler._add_rec_marker=function(A,B){A._pid_time=B;this._rec_markers[A.id]=A;if(!this._rec_markers_pull[A.event_pid]){this._rec_markers_pull[A.event_pid]={}}this._rec_markers_pull[A.event_pid][B]=A};scheduler._get_rec_marker=function(B,C){var A=this._rec_markers_pull[C];if(A){return A[B]}return null};scheduler._get_rec_markers=function(A){return(this._rec_markers_pull[A]||[])};scheduler._del_rec_marker=function(B){var A=this._rec_markers[B];delete this._rec_markers_pull[A.event_pid][A._pid_time];delete this._rec_markers[B]};scheduler._rec_temp=[];scheduler.attachEvent("onEventLoading",function(A){if(A.event_pid!=0){scheduler._add_rec_marker(A,A.event_length*1000)}if(A.rec_type){A.rec_pattern=A.rec_type.split("#")[0]}return true});scheduler.attachEvent("onEventIdChange",function(D,A){if(this._ignore_call){return }this._ignore_call=true;for(var C=0;C<this._rec_temp.length;C++){var B=this._rec_temp[C];if(B.event_pid==D){B.event_pid=A;this.changeEventId(B.id,A+"#"+B.id.split("#")[1])}}delete this._ignore_call});scheduler.attachEvent("onBeforeEventDelete",function(F){var D=this.getEvent(F);if(F.toString().indexOf("#")!=-1){var F=F.split("#");var E=this.uid();var C=this._copy_event(D);C.id=E;C.event_pid=F[0];C.event_length=F[1];C.rec_type=C.rec_pattern="none";this.addEvent(C);this._add_rec_marker(this.getEvent(E),F[1]*1000)}else{if(D.rec_type){this._roll_back_dates(D)}var B=this._get_rec_markers(F);for(var A in B){this.deleteEvent(B[A].id,true)}}return true});scheduler.attachEvent("onEventChanged",function(G){if(this._loading){return true}var E=this.getEvent(G);if(G.toString().indexOf("#")!=-1){var G=G.split("#");var F=this.uid();this._not_render=true;var D=this._copy_event(E);D.id=F;D.event_pid=G[0];D.event_length=G[1];D.rec_type=D.rec_pattern="";this.addEvent(D);this._not_render=false;this._add_rec_marker(this.getEvent(F),G[1]*1000)}else{if(E.rec_type){this._roll_back_dates(E)}var C=this._get_rec_markers(G);for(var B in C){var A=C[B].id;this._del_rec_marker(A);this.deleteEvent(A,true)}this._select_id=null}return true});scheduler.attachEvent("onEventAdded",function(B){if(!this._loading){var A=this.getEvent(B);if(A.rec_type&&!A.event_length){this._roll_back_dates(A)}}return true});scheduler.attachEvent("onEventCreated",function(B){var A=this.getEvent(B);if(!A.rec_type){A.rec_type=A.rec_pattern=""}return true});scheduler.attachEvent("onEventCancel",function(B){var A=this.getEvent(B);if(A.rec_type){this._roll_back_dates(A);this.render_view_data(A.id)}});scheduler._roll_back_dates=function(A){A.event_length=(A.end_date.valueOf()-A.start_date.valueOf())/1000;A.end_date=A._end_date;if(A._start_date){A.start_date.setMonth(0);A.start_date.setDate(A._start_date.getDate());A.start_date.setMonth(A._start_date.getMonth());A.start_date.setFullYear(A._start_date.getFullYear())}};scheduler.validId=function(A){return A.toString().indexOf("#")==-1};scheduler.showLightbox_rec=scheduler.showLightbox;scheduler.showLightbox=function(B){var A=this.getEvent(B).event_pid;if(B.toString().indexOf("#")!=-1){A=B.split("#")[0]}if(!A||A==0||(!this.locale.labels.confirm_recurring||!confirm(this.locale.labels.confirm_recurring))){return this.showLightbox_rec(B)}A=this.getEvent(A);A._end_date=A.end_date;A.end_date=new Date(A.start_date.valueOf()+A.event_length*1000);return this.showLightbox_rec(A.id)};scheduler.get_visible_events_rec=scheduler.get_visible_events;scheduler.get_visible_events=function(){for(var C=0;C<this._rec_temp.length;C++){delete this._events[this._rec_temp[C].id]}this._rec_temp=[];var A=this.get_visible_events_rec();var B=[];for(var C=0;C<A.length;C++){if(A[C].rec_type){if(A[C].rec_pattern!="none"){this.repeat_date(A[C],B)}}else{B.push(A[C])}}return B};(function(){var A=scheduler.is_one_day_event;scheduler.is_one_day_event=function(B){if(B.rec_type){return true}return A.call(this,B)}})();scheduler.transponse_size={day:1,week:7,month:1,year:12};scheduler.date.day_week=function(E,C,D){E.setDate(1);D=(D-1)*7;var B=E.getDay();var A=C*1+D-B+1;E.setDate(A<=D?(A+7):A)};scheduler.transpose_day_week=function(G,D,F,C,E){var A=(G.getDay()||(scheduler.config.start_on_monday?7:0))-F;for(var B=0;B<D.length;B++){if(D[B]>A){return G.setDate(G.getDate()+D[B]*1-A-(C?F:E))}}this.transpose_day_week(G,D,F+C,null,F)};scheduler.transpose_type=function(D){var F="transpose_"+D;if(!this.date[F]){var G=D.split("_");var A=60*60*24*1000;var C="add_"+D;var E=this.transponse_size[G[0]]*G[1];if(G[0]=="day"||G[0]=="week"){var H=null;if(G[4]){H=G[4].split(",");if(scheduler.config.start_on_monday){for(var B=0;B<H.length;B++){H[B]=(H[B]*1)||7}H.sort()}}this.date[F]=function(I,K){var J=Math.floor((K.valueOf()-I.valueOf())/(A*E));if(J>0){I.setDate(I.getDate()+J*E)}if(H){scheduler.transpose_day_week(I,H,1,E)}};this.date[C]=function(K,J){var L=new Date(K.valueOf());if(H){for(var I=0;I<J;I++){scheduler.transpose_day_week(L,H,0,E)}}else{L.setDate(L.getDate()+J*E)}return L}}else{if(G[0]=="month"||G[0]=="year"){this.date[F]=function(I,K){var J=Math.ceil(((K.getFullYear()*12+K.getMonth()*1)-(I.getFullYear()*12+I.getMonth()*1))/(E));if(J>=0){I.setMonth(I.getMonth()+J*E)}if(G[3]){scheduler.date.day_week(I,G[2],G[3])}};this.date[C]=function(J,I){var K=new Date(J.valueOf());K.setMonth(K.getMonth()+I*E);if(G[3]){scheduler.date.day_week(K,G[2],G[3])}return K}}}}};scheduler.repeat_date=function(F,G,C,I,J){I=I||this._min_date;J=J||this._max_date;var E=new Date(F.start_date.valueOf());if(!F.rec_pattern&&F.rec_type){F.rec_pattern=F.rec_type.split("#")[0]}this.transpose_type(F.rec_pattern);scheduler.date["transpose_"+F.rec_pattern](E,I);while(E<F.start_date||(E.valueOf()+F.event_length*1000)<=I.valueOf()){E=this.date.add(E,1,F.rec_pattern)}while(E<J&&E<F.end_date){var A=this._get_rec_marker(E.valueOf(),F.id);if(!A){var H=new Date(E.valueOf()+F.event_length*1000);var B=this._copy_event(F);B.start_date=E;B.event_pid=F.id;B.id=F.id+"#"+Math.ceil(E.valueOf()/1000);B.end_date=H;var D=B.start_date.getTimezoneOffset()-B.end_date.getTimezoneOffset();if(D){if(D>0){B.end_date=new Date(E.valueOf()+F.event_length*1000-D*60*1000)}else{B.end_date=new Date(B.end_date.valueOf()+D*60*1000)}}B._timed=this.is_one_day_event(B);if(!B._timed&&!this._table_view&&!this.config.multi_day){return }G.push(B);if(!C){this._events[B.id]=B;this._rec_temp.push(B)}}else{if(C){G.push(A)}}E=this.date.add(E,1,F.rec_pattern)}};scheduler.getRecDates=function(B,H){var G=typeof B=="object"?B:scheduler.getEvent(B);var E=0;var J=[];H=H||1000;var C=new Date(G.start_date.valueOf());var I=new Date(C.valueOf());if(!G.rec_type){return[{start_date:G.start_date,end_date:G.end_date}]}this.transpose_type(G.rec_pattern);scheduler.date["transpose_"+G.rec_pattern](C,I);while(C<G.start_date||(C.valueOf()+G.event_length*1000)<=I.valueOf()){C=this.date.add(C,1,G.rec_pattern)}while(C<G.end_date){var A=this._get_rec_marker(C.valueOf(),G.id);if(!A){var F=new Date(C.valueOf()+G.event_length*1000);var D=new Date(C);J.push({start_date:D,end_date:F});C=this.date.add(C,1,G.rec_pattern);E++}if(E==H){break}}return J};scheduler.getEvents=function(G,F){var A=[];for(var B in this._events){var D=this._events[B];if(D&&D.start_date<F&&D.end_date>G){if(D.rec_pattern){if(D.rec_pattern=="none"){continue}var E=[];this.repeat_date(D,E,true,G,F);for(var C=0;C<E.length;C++){if(!E[C].rec_pattern&&E[C].start_date<F&&E[C].end_date>G){A.push(E[C])}}}else{if(!D.event_pid||D.event_pid==0){A.push(D)}}}}return A};scheduler.config.repeat_date="%m.%d.%Y";scheduler.config.lightbox.sections=[{name:"description",height:130,map_to:"text",type:"textarea",focus:true},{name:"recurring",height:115,type:"recurring",map_to:"rec_type",button:"recurring"},{name:"time",height:72,type:"time",map_to:"auto"}];scheduler._copy_dummy=function(A){this.start_date=new Date(this.start_date);this.end_date=new Date(this.end_date);this.event_length=this.event_pid=this.rec_pattern=this.rec_type=this._timed=null};scheduler.__recurring_template='<div class="dhx_form_repeat"> <form> <div class="dhx_repeat_left"> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="day" />Daily</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="week"/>Weekly</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="month" checked />Monthly</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="year" />Yearly</label> </div> <div class="dhx_repeat_divider"></div> <div class="dhx_repeat_center"> <div style="display:none;" id="dhx_repeat_day"> <label><input class="dhx_repeat_radio" type="radio" name="day_type" value="d"/>Every</label><input class="dhx_repeat_text" type="text" name="day_count" value="1" />day<br /> <label><input class="dhx_repeat_radio" type="radio" name="day_type" checked value="w"/>Every workday</label> </div> <div style="display:none;" id="dhx_repeat_week"> Repeat every<input class="dhx_repeat_text" type="text" name="week_count" value="1" />week next days:<br /> <table class="dhx_repeat_days"> <tr> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="1" />Monday</label><br /> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="4" />Thursday</label> </td> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="2" />Tuesday</label><br /> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="5" />Friday</label> </td> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="3" />Wednesday</label><br /> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="6" />Saturday</label> </td> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="0" />Sunday</label><br /><br /> </td> </tr> </table> </div> <div id="dhx_repeat_month"> <label><input class="dhx_repeat_radio" type="radio" name="month_type" value="d"/>Repeat</label><input class="dhx_repeat_text" type="text" name="month_day" value="1" />day every<input class="dhx_repeat_text" type="text" name="month_count" value="1" />month<br /> <label><input class="dhx_repeat_radio" type="radio" name="month_type" checked value="w"/>On</label><input class="dhx_repeat_text" type="text" name="month_week2" value="1" /><select name="month_day2"><option value="1" selected >Monday<option value="2">Tuesday<option value="3">Wednesday<option value="4">Thursday<option value="5">Friday<option value="6">Saturday<option value="0">Sunday</select>every<input class="dhx_repeat_text" type="text" name="month_count2" value="1" />month<br /> </div> <div style="display:none;" id="dhx_repeat_year"> <label><input class="dhx_repeat_radio" type="radio" name="year_type" value="d"/>Every</label><input class="dhx_repeat_text" type="text" name="year_day" value="1" />day<select name="year_month"><option value="0" selected >January<option value="1">February<option value="2">March<option value="3">April<option value="4">May<option value="5">June<option value="6">July<option value="7">August<option value="8">September<option value="9">October<option value="10">November<option value="11">December</select>month<br /> <label><input class="dhx_repeat_radio" type="radio" name="year_type" checked value="w"/>On</label><input class="dhx_repeat_text" type="text" name="year_week2" value="1" /><select name="year_day2"><option value="1" selected >Monday<option value="2">Tuesday<option value="3">Wednesday<option value="4">Thursday<option value="5">Friday<option value="6">Saturday<option value="7">Sunday</select>of<select name="year_month2"><option value="0" selected >January<option value="1">February<option value="2">March<option value="3">April<option value="4">May<option value="5">June<option value="6">July<option value="7">August<option value="8">September<option value="9">October<option value="10">November<option value="11">December</select><br /> </div> </div> <div class="dhx_repeat_divider"></div> <div class="dhx_repeat_right"> <label><input class="dhx_repeat_radio" type="radio" name="end" checked/>No end date</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="end" />After</label><input class="dhx_repeat_text" type="text" name="occurences_count" value="1" />occurrences<br /> <label><input class="dhx_repeat_radio" type="radio" name="end" />End by</label><input class="dhx_repeat_date" type="text" name="date_of_end" value="01.01.2010" /><br /> </div> </form> </div> <div style="clear:both"> </div>';