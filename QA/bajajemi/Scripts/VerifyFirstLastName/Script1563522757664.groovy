import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
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


String name=WebUI.getText(findTestObject("Object Repository/MyAccount/GetAccountName"));

String[] firstLast=name.split(" ")


WebUI.click(findTestObject("Object Repository/MyAccount/UserIcon"));

Thread.sleep(2000)

WebUI.click(findTestObject("Object Repository/MyAccount/MyAcc"));

WebUI.click(findTestObject("Object Repository/MyAccount/EditButton"));

String firstName=WebUI.getAttribute(findTestObject("Object Repository/MyAccount/firstName"),'value');

String lastName=WebUI.getAttribute(findTestObject("Object Repository/MyAccount/lastName"),'value');

Assert.assertEquals(firstLast[0], firstName);

Assert.assertEquals(firstLast[1], lastName);

WebUI.click(findTestObject("Object Repository/GenericButtons/HeaderLogo"))

WebUI.mouseOver(findTestObject("Category/Electronics"))

WebUI.waitForElementClickable(findTestObject("Category/Smartphones"), 5)

WebUI.click(findTestObject("Category/Smartphones"))



