
(function($,Edge,compId){var Composition=Edge.Composition,Symbol=Edge.Symbol;
//Edge symbol: 'stage'
(function(symbolName){Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",5000,function(sym,e){sym.stop();});
//Edge binding end
Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",8000,function(sym,e){sym.stop();});
//Edge binding end
Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",12000,function(sym,e){sym.stop();});
//Edge binding end
Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",15000,function(sym,e){sym.stop();});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button4}","click",function(sym,e){sym.play(14750);});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button3}","click",function(sym,e){sym.play(11999);});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button2}","click",function(sym,e){sym.play(7750);});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button1}","click",function(sym,e){sym.play(4750);});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button1}","mouseover",function(sym,e){var button=sym.getSymbol('button1');sym.$('button1').css({'background-color':'#7f7f7f','border-color':'#37bfd3'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button1}","mouseout",function(sym,e){var button1=sym.getSymbol('button1');sym.$('button1').css({'background-color':'#c0c0c0','border-color':'#c0c0c0'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button2}","mouseout",function(sym,e){var button1=sym.getSymbol('button2');sym.$('button2').css({'background-color':'#c0c0c0','border-color':'#c0c0c0'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button2}","mouseover",function(sym,e){var button=sym.getSymbol('button2');sym.$('button2').css({'background-color':'#7f7f7f','border-color':'#37bfd3'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button3}","mouseover",function(sym,e){var button=sym.getSymbol('button3');sym.$('button3').css({'background-color':'#7f7f7f','border-color':'#37bfd3'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button3}","mouseout",function(sym,e){var button1=sym.getSymbol('button3');sym.$('button3').css({'background-color':'#c0c0c0','border-color':'#c0c0c0'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button4}","mouseout",function(sym,e){var button1=sym.getSymbol('button4');sym.$('button4').css({'background-color':'#c0c0c0','border-color':'#c0c0c0'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_button4}","mouseover",function(sym,e){var button=sym.getSymbol('button4');sym.$('button4').css({'background-color':'#7f7f7f','border-color':'#37bfd3'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_p-right}","click",function(sym,e){sym.play();});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_p-left}","click",function(sym,e){sym.playReverse();});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_p-right}","mouseover",function(sym,e){var button1=sym.getSymbol('p-right');sym.$('p-right').css({'opacity':'0.5'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_p-right}","mouseout",function(sym,e){var button1=sym.getSymbol('p-right');sym.$('p-right').css({'opacity':'1'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_p-left}","mouseout",function(sym,e){var button1=sym.getSymbol('p-left');sym.$('p-left').css({'opacity':'1'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"${_p-left}","mouseover",function(sym,e){var button1=sym.getSymbol('p-left');sym.$('p-left').css({'opacity':'0.5'});});
//Edge binding end
Symbol.bindElementAction(compId,symbolName,"document","compositionReady",function(sym,e){sym.$('#Stage').css({'transform-origin':'0 0','-ms-transform-origin':'0 0','-webkit-transform-origin':'0 0','-moz-transform-origin':'0 0','-o-transform-origin':'0 0'});function scaleStage(){var stage=sym.$('Stage');var parent=sym.$('Stage').parent();var parentWidth=stage.parent().width();var parentHeight=$(window).height();var stageWidth=stage.width();var stageHeight=stage.height();var desiredWidth=Math.round(parentWidth*1);var desiredHeight=Math.round(parentHeight*1);var rescaleWidth=(desiredWidth/stageWidth);var rescaleHeight=(desiredHeight/stageHeight);var rescale=rescaleWidth;if(stageHeight*rescale>desiredHeight)
rescale=rescaleHeight;stage.css('transform','scale('+rescale+')');stage.css('-o-transform','scale('+rescale+')');stage.css('-ms-transform','scale('+rescale+')');stage.css('-webkit-transform','scale('+rescale+')');stage.css('-moz-transform','scale('+rescale+')');stage.css('-o-transform','scale('+rescale+')');parent.height(stageHeight*rescale);}
$(window).on('resize',function(){scaleStage();});$(document).ready(function(){scaleStage();});});
//Edge binding end
})("stage");
//Edge symbol end:'stage'
})(jQuery,AdobeEdge,"FreshRadioUk-mobile");