import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import org.openqa.selenium.By
import org.openqa.selenium.Keys
import plp.Resources
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable

//@Author : Amit Baghel.
WebUI.click(findTestObject("Object Repository/FilterButtons/a_Filter"))

Thread.sleep(2000)

WebUI.click(findTestObject("Object Repository/FilterButtons/EmiExpandOption"))

Resources.moveSlider();

String s=WebUI.getText(findTestObject("Object Repository/FilterButtons/EMIRange"))

String[] emiRange=s.split("-");

String[] lowerRange=emiRange[0].split("\\.");
lowerRange[1]=lowerRange[1].replaceAll(",","");
String[] higherRange=emiRange[1].split("\\.");
higherRange[1]=higherRange[1].replaceAll(",","");


WebUI.click(findTestObject("Object Repository/FilterButtons/ApplyButton"))

Thread.sleep(4000)

int totalProductCount=Resources.VerifyEmiRangeTotalCount();
for(int i=1;i<=totalProductCount;i++){
	String s1=WebUI.getText(findTestObject("Object Repository/FilterButtons/EMIOfProduct"))
	String[] emiValue=s1.split("\\.");
	emiValue[1]=emiValue[1].replaceAll(",","");
	if(emiValue[1]>=lowerRange[1] && emiValue[1]<=higherRange[1]){
		continue;
	}
}




