import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import plp.Resources
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable



//@Author : Amit Baghel.

Resources.selectCity();

WebUI.waitForElementNotPresent(findTestObject("Object Repository/GenericButtons/SingInButton"), 5)

WebUI.click(findTestObject("Object Repository/GenericButtons/SingInButton"))

WebUI.waitForElementNotPresent(findTestObject('Login/FirstName'),5);

WebUI.sendKeys(findTestObject("Object Repository/Login/MobileNumber"),GlobalVariable.phoneNumber)

WebUI.sendKeys(findTestObject("Login/FirstName"),GlobalVariable.firstName)

WebUI.sendKeys(findTestObject("Login/LastName"),GlobalVariable.lastName)

//WebUI.click(findTestObject("Object Repository/Login/AcceptCheckbox"))

//Thread.sleep(3000);

//WebUI.waitForElementNotPresent(findTestObject("Object Repository/Login/getotpbutton"),5);

WebUI.waitForElementNotPresent(findTestObject("Object Repository/Login/Button"), 5);

WebUI.click(findTestObject("Object Repository/Login/Button"))

Thread.sleep(20000);

WebUI.click(findTestObject("Object Repository/Login/Verify"));


//WebUI.click(findTestObject("Object Repository/Login/CloseButton"));
