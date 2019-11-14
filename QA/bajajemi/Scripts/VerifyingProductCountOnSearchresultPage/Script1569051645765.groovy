import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import org.openqa.selenium.WebDriver
import org.openqa.selenium.By
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
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
import plp.Resources



WebUI.setText(findTestObject("Object Repository/Search/SearchinputFiled"),Resources.namesofProducts.get(1));

WebDriver driver=DriverFactory.getWebDriver();

String s=WebUI.getText(findTestObject("Object Repository/Search/ShowAllResults"))

Thread.sleep(3000);

WebUI.click(findTestObject("Object Repository/Search/ShowAllResults"));

String productResultCount=s.split(" ");

String productCount=productResultCount[2];

println(productCount);

for(int i=1;i<=productCount;i++){
	
	//Check the Lazy Load of the Search results Page.
	
	//Now, Count the Number of Products Loaded.
	
	//Than map the Number of Products to the productCountVariable.
}