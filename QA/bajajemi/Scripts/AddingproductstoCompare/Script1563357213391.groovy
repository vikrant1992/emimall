import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import plp.Resources as Resources
import pom_files.ComparePage
import org.openqa.selenium.WebDriver as WebDriver
import org.testng.Assert
import org.openqa.selenium.By as By
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory as DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable


//@Author : Amit Baghel.
WebDriver driver = DriverFactory.getWebDriver()

ArrayList<String> productNames=new ArrayList<>();

WebUI.mouseOver(findTestObject("Object Repository/PLPpage/PLP_Title"))

boolean flag=false;
//Verify if the Compare pop-up is appearing before any product is added.
//flag=WebUI.waitForElementPresent(findTestObject("Object Repository/CompareFunctionality/ComparePopUp"),2);

//Assert.assertFalse(flag);

//This is used to Add Products to Compare Page and than verify if the Compare Pop-up is Appearing.
for (int i = 1; i <= (GlobalVariable.nosOfProducts)*2; i+=2) {
	
	WebUI.waitForElementNotPresent(findTestObject("Object Repository/PLPpage/CompareButton"), 3);
	
	//productNames.add(WebUI.getText(findTestObject("Object Repository/PLPpage/ProductNamesPLP",[('{index}'):i])));
	
	productNames.add(driver.findElement(By.xpath("//div[@id='layer-product-list']/div[3]/ol/li["+ i +"]/div/div[2]/strong/a")).getText());
	
	driver.findElement(By.xpath("(//div[@class='CompareButton-wrapper'])["+i+"]")).click();
}

Resources.namesofProducts=productNames;

//println(productNames);

Thread.sleep(3000);

//Here we are giving the Count of the 
String count=WebUI.callTestCase(findTestCase('Test Cases/VerifyComparePopUpCount'), null);

Assert.assertEquals(Integer.parseInt(count),GlobalVariable.nosOfProducts);

//Verifying the Pop-up Text on the Compare Page.
WebUI.callTestCase(findTestCase("Test Cases/AddingExtraProductToCompare"),null);


WebUI.waitForElementNotPresent(findTestObject("Object Repository/CompareFunctionality/ComparePopUp"), 5);

WebUI.click(findTestObject('Object Repository/CompareFunctionality/ComparePopUp'));

//Calling the size Method to check the nos. of Elements on the Compare Page.
ComparePage com=new ComparePage(driver);

//Getting the Nos of Products on the Compare Page.
int noofElements=com.compareElementsSize();

//Verifying if the Nos of Products are Equal to the number of Products Added.
Assert.assertEquals(noofElements,GlobalVariable.nosOfProducts);


//Verifying the Product Count on the Compare Page.
for(int j=1;j <= GlobalVariable.nosOfProducts; j++) {
	
	//String s=WebUI.getAttribute(findTestObject("Object Repository/CompareFunctionality/ProductText"), null);
	
	//WebUI.click(findTestObject("Object Repository/CompareFunctionality/ProductNumber"));
	
	driver.findElement(By.xpath("//div[@class='p_designbox']["+j+"]")).click();
	
	String s=WebUI.getText(findTestObject("Object Repository/CompareFunctionality/ProductName"));
	
	WebUI.back();
	
	Assert.assertEquals(productNames.get(j-1),s);
}


//Moving to the Categories Page.i.e Mobiles and Electronics.
//Resources.movingToSmartphonesPage();



