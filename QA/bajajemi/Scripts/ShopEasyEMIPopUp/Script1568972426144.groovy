import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import org.openqa.selenium.WebDriver
import org.testng.Assert
import org.openqa.selenium.By
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable

//@Author : Amit Baghel.
//Date : 20/9/2019.


// This test Case is used to verify if the pop-up of Categories is appearing
//if the user clicks on Shop All Easy EMIs.



WebUI.click(findTestObject("Object Repository/Homepage/ShopOnEMI"));

WebDriver driver =DriverFactory.getWebDriver();

Assert.assertTrue(driver.findElement(By.xpath("//div[@class='shoponEasyEmiPopUp']")).isDisplayed());
