import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import org.openqa.selenium.WebDriver
import org.openqa.selenium.WebElement
import org.openqa.selenium.By
import org.testng.Assert
import plp.Resources
import plp.ProductDetailPage
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable

//@Author: Amit Baghel
//Date: 15/7/2019
Resources.checkFilterButtons();

Resources.verifyFilter();

WebDriver driver=Resources.driver;
int i;
int totalProductCount=Resources.getTotalCount();

WebUI.scrollToPosition(0, 5000);

Thread.sleep(3000);

WebUI.click(findTestObject('PLPpage/Footer_doYouKnow_Text'))

for(i=1;i<=totalProductCount;i++){
	String detail=driver.findElement(By.xpath("//div[@id='layer-product-list']/div[7]/div/div["+i+"]/div/div[2]")).getText();
	println(detail);
	if(detail.contains("LG")){
		continue;
	}else{
	    break;
	}
}


//Assert.assertEquals(totalProductCount,i)





