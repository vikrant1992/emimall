import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import org.openqa.selenium.WebDriver
import org.testng.Assert
import org.openqa.selenium.By
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable
import plp.Resources


//@Author : Amit Baghel
//Date: 15/9/2019

//boolean result=Resources.selectCityPopup();

//Assert.assertFalse(result);

//Resources.selectCity();


WebUI.mouseOver(findTestObject("Object Repository/PLPpage/PLP_Title"))

ArrayList<String> categoryNames=new ArrayList<>();

WebDriver driver =DriverFactory.getWebDriver();

int size=driver.findElements(By.xpath("//div[@class='a_deskcatagory']/ul/li")).size();

for(int i=1;i<=size;i++){
		
	WebUI.waitForElementNotPresent(findTestObject("Object Repository/Category_Traverse/Categories"), 5)
		
	WebUI.click(findTestObject("Object Repository/Category_Traverse/Categories"));
	
	WebUI.waitForElementNotPresent(findTestObject("Object Repository/Category_Traverse/CommonCategoryList"), 5);
	
	categoryNames.add(driver.findElement(By.xpath("//div[@class='a_deskcatagory']/ul/li["+i+"]/a")).getText());
	
	driver.findElement(By.xpath("//div[@class='a_deskcatagory']/ul/li["+i+"]/a")).click();
	
	String match=WebUI.getText(findTestObject("Object Repository/PLPpage/PLP_Title"));
	
	Assert.assertEquals(match, categoryNames.get(i-1));
	
	WebUI.back();
}