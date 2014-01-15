tx.exe pull -a --skip


for %%a in (*.po) do (
	echo ' Translating %%a'
	
	msgfmt -cv -o %%~na.mo %%a
	del %%a

)

PAUSE