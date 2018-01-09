function writeFlash(FlashFile,width, height) 
{ 
document.writeln(" <object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http:\/\/download.macromedia.com\/pub\/shockwave\/cabs\/flash\/swflash.cab#version=9,0,28,0\" width=\""+width+"\" height=\""+height+"\"> "); 
document.writeln("          <param name=\"movie\" value=\""+FlashFile+"\" \/> "); 
document.writeln("          <param name=\"quality\" value=\"high\" \/> "); 
document.writeln("          <param name=\"wmode\" value=\"transparent\" \/> "); 
document.writeln("          <embed src=\""+FlashFile+"\" quality=\"high\" pluginspage=\"http:\/\/www.adobe.com\/shockwave\/download\/download.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application\/x-shockwave-flash\" width=\""+width+"\" height=\""+height+"\" wmode=\"transparent\"> <\/embed> "); 
document.writeln("    <\/object> ") 
} 