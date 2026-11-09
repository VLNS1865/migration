// SERVER 1865 - Google Sheets backend.
// Run setup() once, then deploy as a Web App: Execute as Me / Access Anyone.

const TAB = "Applications";
const HEADERS = ["Submitted At (UTC)","In-game Name","Current Server","Total Heroes Power","HQ Level","Main Squad Power","Current Alliance","Additional Information"];

function setup() {
  const props = PropertiesService.getScriptProperties();
  let id = props.getProperty("SPREADSHEET_ID");
  const ss = id ? SpreadsheetApp.openById(id) : SpreadsheetApp.create("Server 1865 - Migration Applications");
  if (!id) props.setProperty("SPREADSHEET_ID", ss.getId());
  let sh = ss.getSheetByName(TAB) || ss.insertSheet(TAB);
  if (sh.getLastRow() === 0) {
    sh.appendRow(HEADERS);
    sh.setFrozenRows(1);
    sh.getRange(1,1,1,HEADERS.length).setFontWeight("bold").setBackground("#263445").setFontColor("#ffffff");
    sh.getRange("D:D").setNumberFormat("#,##0");
    sh.getRange("F:F").setNumberFormat("#,##0");
    [175,190,120,180,90,170,180,380].forEach((w,i)=>sh.setColumnWidth(i+1,w));
  }
  Logger.log("PRIVATE ADMIN SHEET: " + ss.getUrl());
  return ss.getUrl();
}

function doPost(e) {
  const lock = LockService.getScriptLock();
  try {
    lock.waitLock(15000);
    const p = e && e.parameter ? e.parameter : {};
    const name = clean(p.playerName,50), server = clean(p.currentServer,12);
    const heroes = intOrNull(p.heroesPower), hq = intOrNull(p.hqLevel), squad = intOrNull(p.mainSquadPower);
    if (!name || !server || heroes === null || hq === null || squad === null || heroes < 0 || squad < 0 || hq < 1 || hq > 40)
      throw new Error("Invalid required fields");
    const id = PropertiesService.getScriptProperties().getProperty("SPREADSHEET_ID");
    if (!id) throw new Error("Run setup() first");
    const sh = SpreadsheetApp.openById(id).getSheetByName(TAB);
    sh.appendRow([new Date(),name,server,heroes,hq,squad,clean(p.alliance,60),clean(p.additionalInfo,1200)]);
    const last = sh.getLastRow();
    if (last > 2) sh.getRange(2,1,last-1,HEADERS.length).sort({column:4,ascending:false});
    return ContentService.createTextOutput(JSON.stringify({success:true})).setMimeType(ContentService.MimeType.JSON);
  } catch(err) {
    console.error(err);
    return ContentService.createTextOutput(JSON.stringify({success:false,error:String(err)})).setMimeType(ContentService.MimeType.JSON);
  } finally { try { lock.releaseLock(); } catch(_) {} }
}
function clean(v,n){ return String(v||"").trim().slice(0,n); }
function intOrNull(v){ if(v===undefined||v===null||String(v).trim()==="")return null; const n=Number(v); return Number.isSafeInteger(n)?n:null; }
