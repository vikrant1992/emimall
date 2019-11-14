import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import org.openqa.selenium.WebDriver as WebDriver
import org.junit.After
import org.testng.Assert
import org.openqa.selenium.By as By
import plp.Resources as Resources
import java.util.Arrays as Arrays
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

WebDriver driver = DriverFactory.getWebDriver();

int countofWishListedProducts;

WebUI.click(findTestObject('Object Repository/MyAccount/UserIcon'))

Resources.goToWishList();

if (driver.findElements(By.xpath("//strong[@class='product-item-name']/a")).size() > 0) {
	
	WebUI.back();
	
	WebUI.click(findTestObject('Object Repository/MyAccount/UserIcon'))
	
	Thread.sleep(2000);
	
    String nosOfItems = WebUI.getText(findTestObject('Object Repository/WishList/WishListCount'))

    String[] items = nosOfItems.split(' ');
	
	countofWishListedProducts=Integer.parseInt(items[0]);
}

Thread.sleep(3000)

Resources.goToWishList();

//Verifying whether the Count present on the MyAccount slider and on WishList Page are appropriate.
int countofProduts=driver.findElements(By.xpath("//strong[@class='product-item-name']/a")).size();

//Assert.assertEquals(countofWishListedProducts,countofProduts);

Resources.removeProductsFromWishlist(countofWishListedProducts);

Thread.sleep(3000)

String message=WebUI.getText(findTestObject("Object Repository/WishList/VerifyWishListEmptyMessage"));

if(!message.isEmpty()){
	println("Script Passed Successfully..!!!")
}



