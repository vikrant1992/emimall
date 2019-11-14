import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import org.openqa.selenium.WebDriver
import plp.Resources
import org.testng.Assert
import org.openqa.selenium.By
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable


//@Author : Amit Baghel
//Date : 19/9/2019


WebDriver driver=DriverFactory.getWebDriver();

WebUI.click(findTestObject("Object Repository/CompareFunctionality/HideCommonFeaturesCheckbox"))

 String style=WebUI.getAttribute(findTestObject("Object Repository/CompareFunctionality/CommonRows"), 'style')
 
 println(style);

 boolean flag=true;
 
 Assert.assertEquals(flag,!style.isEmpty());
 
 //Resources.movingToSmartphonesPage();
 