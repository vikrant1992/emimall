import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import plp.Resources
import org.testng.Assert
import org.openqa.selenium.WebDriver
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable

//@Author : Amit Baghel.
WebDriver driver=DriverFactory.getWebDriver();

Thread.sleep(3000)

WebUI.click(findTestObject('Object Repository/CompareFunctionality/i_Get This Product_fa fa-times'))

Thread.sleep(3000);

//Need to Verify this text with some Data Driven Test...	
String confirmMessage=WebUI.getText(findTestObject('Object Repository/CompareFunctionality/CompareWarningpPopup'))

WebUI.click(findTestObject('Object Repository/CompareFunctionality/span_OK'))

//Need to verify this success Message....
//This similar thing  to be done using Excel.
//String successMessage=WebUI.getText(findTestObject('Object Repository/CompareFunctionality/CompareWarningpPopup'))

Assert.assertNotNull(confirmMessage);

GlobalVariable.nosOfProducts--;

WebUI.refresh();

int count=Resources.nosOfProductsonComparePage(driver);

Assert.assertEquals(count,GlobalVariable.nosOfProducts);

//One more test to check the Cancel Button on the Compare Page after we click on the Close Button.

Resources.movingToSmartphonesPage();


//Verifying if the Product Count has decreased from the Compare Pop up as Well.

String productCount=WebUI.callTestCase(findTestCase('Test Cases/VerifyComparePopUpCount'), null);

Assert.assertEquals(Integer.parseInt(productCount),GlobalVariable.nosOfProducts);





