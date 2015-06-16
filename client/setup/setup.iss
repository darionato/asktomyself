[Setup]
OutputDir=Q:\asktomyself\client\setup
VersionInfoVersion=1.0.0.4
VersionInfoCompany=Badlydone
VersionInfoDescription=Ask To Mysef
VersionInfoTextVersion=1.0.0.4
VersionInfoCopyright=Copyright Badlydone 2010
VersionInfoProductName=Ask To Myself
VersionInfoProductVersion=1.0.0.4
PrivilegesRequired=none
ShowLanguageDialog=no
SetupIconFile=q:\asktomyself\client\askme\emoticon_happy.ico
AppCopyright=Badlydone 2010
AppName=Ask To Myself
AppVerName=Ask To Myself 1.0.0.4
DefaultGroupName=Ask To Myself
DefaultDirName={pf}\Ask To Myself
OutputBaseFilename=..\..\server\app\win\asktomyself_1.0.0.4
[Tasks]
Name: desktopicon; Description: {cm:CreateDesktopIcon}; GroupDescription: {cm:AdditionalIcons}; Flags: unchecked
[Files]
Source: ..\askme\bin\Release\asktomyself.exe; DestDir: {app}; Flags: overwritereadonly replacesameversion
Source: ..\askme\bin\Release\asktomyself.XmlSerializers.dll; DestDir: {app}; Flags: overwritereadonly replacesameversion
Source: emoticon_unhappy.ico; DestDir: {app}; DestName: Uninstall.ico; Flags: deleteafterinstall
[Icons]
Name: {group}\Ask To Myself; Filename: {app}\asktomyself.exe; IconIndex: 0
Name: {group}\{cm:UninstallProgram,Ask To Myself}; Filename: {uninstallexe}; IconFilename: {app}\Uninstall.ico; IconIndex: 0
Name: {commondesktop}\Ask To Myself; Filename: {app}\asktomyself.exe; IconIndex: 0; Tasks: desktopicon
[CustomMessages]
dotnetmissing=This application needs Microsoft .Net Version 3.5. Do you like to download and install it now?

dotnetmissing=This application needs Microsoft .Net 3.5 which is not yet installed. Do you like to download it now?
[Code]
function InitializeSetup(): Boolean;
var
    ErrorCode: Integer;
    netFrameWorkInstalled : Boolean;
    isInstalled: Cardinal;
begin
  result := true;

    // Check for the .Net 3.5 framework
  isInstalled := 0;
  netFrameworkInstalled := RegQueryDWordValue(HKLM, 'SOFTWARE\Microsoft\NET Framework Setup\NDP\v3.5', 'Install', isInstalled);
  if ((netFrameworkInstalled)  and (isInstalled <> 1)) then netFrameworkInstalled := false;

  if netFrameworkInstalled = false then
  begin
    if (MsgBox(ExpandConstant('{cm:dotnetmissing}'),
        mbConfirmation, MB_YESNO) = idYes) then
    begin
      ShellExec('open',
      'http://www.microsoft.com/downloads/details.aspx?FamilyID=333325fd-ae52-4e35-b531-508d977d32a6&DisplayLang=en',
      '','',SW_SHOWNORMAL,ewNoWait,ErrorCode);
    end;
    result := false;
  end;

end;

