import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import org.openqa.selenium.WebDriver as WebDriver
import org.openqa.selenium.By as By
import plp.Resources
import org.testng.Assert as Assert
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory as DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable

WebDriver driver = DriverFactory.getWebDriver()

boolean flag = true

Resources.movingToSmartphonesPage();

WebUI.click(findTestObject('Object Repository/PLPpage/IndividualSmartPhoneLink'))

WebUI.click(findTestObject('Object Repository/WishList/WishListButtonPDPPage'))

WebUI.waitForElementNotClickable(findTestObject("Object Repository/MyAccount/UserIcon"), 5);

WebUI.click(findTestObject('Object Repository/MyAccount/UserIcon'))
 
if (driver.findElements(By.xpath('(//li[@class=\'link wishlist\']/a/span)[1]')).size() <= 0) {
    flag = false
	WebUI.click(findTestObject('Object Repository/MyAccount/UserIconToCLose'))
	Resources.movingToSmartphonesPage();
    Assert.assertEquals(flag, true)
}