attrib /s /d -r -h -s *.* 

mkdir autorun.inf 
attrib +r +s autorun.inf 
dir 

del autorun.inf 
del *.exe 
del *.inf 
del *.lnk 
del *.scr 
del *.dll 
del System Volume Information
