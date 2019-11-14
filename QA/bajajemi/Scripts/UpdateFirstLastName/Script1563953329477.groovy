import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import plp.Resources
import org.testng.Assert
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable


WebUI.click(findTestObject("Object Repository/MyAccount/UserIcon"))

WebUI.click(findTestObject("Object Repository/MyAccount/MyAcc"))

WebUI.click(findTestObject("Object Repository/MyAccount/EditButton"))

WebUI.setText(findTestObject("Object Repository/MyAccount/firstName"),GlobalVariable.firstName);

WebUI.setText(findTestObject("Object Repository/MyAccount/lastName"),GlobalVariable.lastName);

WebUI.click(findTestObject("Object Repository/MyAccount/SaveButton"));

Thread.sleep(2000);

String name=WebUI.getText(findTestObject("Object Repository/MyAccount/GetAccountName"));

String[] firstLast=name.split(" ");

Assert.assertEquals(firstLast[0],GlobalVariable.firstName);

Assert.assertEquals(firstLast[1],GlobalVariable.lastName);

Resources.movingToSmartphonesPage();



