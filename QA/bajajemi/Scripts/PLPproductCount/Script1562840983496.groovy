import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import org.openqa.selenium.WebDriver as WebDriver
import org.openqa.selenium.interactions.Actions
import org.openqa.selenium.WebElement
import org.testng.Assert
import com.kms.katalon.core.annotation.SetUp
import com.kms.katalon.core.annotation.SetupTestCase
import com.kms.katalon.core.annotation.Keyword
import org.openqa.selenium.By as By
import org.openqa.selenium.Keys as Keys
import plp.Resources
import plp.CountProducts as CountProducts
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory as DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable



//@Author=Amit Baghel
//Date : 11/7/2019
//Modified Date : 13/9/2019

//WebUI.openBrowser('');
//
//WebDriver driver = DriverFactory.getWebDriver();
//
//WebUI.navigateToUrl("http://172.27.25.203:8080")
//
//Resources.maximizeBrowser();

int i=3;

Resources.selectCity();

Thread.sleep(2000);

//Resources.movingToSmartphonesPage();
Resources.movingToSmartphonesPage();

//Here we are checking if the Compare pop up is present on the Homepage itself.
Assert.assertFalse(Resources.checkifComparepopuppresent());

//File fis=new File("Object Repository/PLPpage/PLPobjectsCount");
int incrementCount=0;

CountProducts count = new CountProducts();

//Getting the Total nos of proucts that are present.
int totalProductCount = Resources.getTotalCount();

//Verifying whether the 30 product load is appropriate.
int total=Resources.verifyLoadCount(i, totalProductCount, count);

//Verify the Flag value for Lazy load Functionality or Else Product Count.


//Verifying if the Total product Count displayed is equal to the nos. of Products that are actually present.
Assert.assertEquals(total, totalProductCount);








