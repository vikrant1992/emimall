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


//@Author :Amit Baghel
//(Non Logged in Customer...)
WebDriver driver= DriverFactory.getWebDriver();
// This block generally checks a condition. i.e 
//Customer with and W/o LOGIN clicking on the wishlist Button.
if(driver.findElements(By.xpath("//div[@class='panel header']/ul/li[2]")).size()>0){
	WebUI.click(findTestObject("Object Repository/WishList/WishlistbuttobonComparePage"))
	
	String message=WebUI.getText(findTestObject("Object Repository/WishList/CustomerNotLoggedInPopup"));
	
	Assert.assertEquals(true,!message.isEmpty())
}
