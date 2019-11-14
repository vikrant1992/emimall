import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import org.openqa.selenium.By
import pom_files.PLPFilterOptions
import org.openqa.selenium.WebDriver
import org.openqa.selenium.WebElement
import org.openqa.selenium.interactions.Actions
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
import plp.CountProducts

WebDriver driver=DriverFactory.getWebDriver();

CountProducts count=new CountProducts();

boolean flag=false;

//Resources.selectCity();

Thread.sleep(3000);

WebUI.waitForElementPresent(findTestObject("Object Repository/Category_Traverse/Categories"), 5)

WebUI.click(findTestObject("Object Repository/Category_Traverse/Categories"));

WebUI.click(findTestObject("Object Repository/Category_Traverse/Mobile and Electronics"));

ArrayList<String> brandNames=new ArrayList<>(); 

//Passing the driver object for the POM model.
PLPFilterOptions options=new PLPFilterOptions(driver);

//Getting the Size of all the Filetr headers
int size=options.filterHeaders();

//Now need to check the Brand Filter among those
for(int i=2;i<=size;i++){
	String s=driver.findElement(By.xpath("//div[@class='filter-options']/div["+i+"]/div[1]")).getText();
	
	if(s.equals("Brand")){
		Actions a=new Actions(driver);
		
		int brandSize=driver.findElements(By.xpath("//div[@class='filter-options']/div["+i+"]/div[2]/ol/li")).size();
		
		for(int j=1;j<=brandSize;j++){
			
			
			int count1=driver.findElements(By.className("filter-options-item allow active")).size();
			
			if(count1>0){
				
		brandNames.add(driver.findElement(By.xpath("//div[@class='filter-options']/div["+i+"]/div[2]/ol/li["+j+"]")).getText());
		
			}else{
			
			a.moveToElement(driver.findElement(By.xpath("//div[@class='filter-options']/div["+i+"]/div[1]"))).build().perform(); 
			
			driver.findElement(By.xpath("//div[@class='filter-options']/div["+i+"]/div[1]")).click();
			
			brandNames.add(driver.findElement(By.xpath("//div[@class='filter-options']/div["+i+"]/div[2]/ol/li["+j+"]")).getText());
			
			}
		
		
//		if(brandNames.get(j-1).equals("Connectivity")){
//		
//			WebElement ele=driver.findElement(By.xpath("//div[@class='filter-options']/div["+i+"]/div[2]/ol/li["+j+"]"));
//			
//			Actions act=new Actions(driver);
//			
//			act.moveToElement(ele).build().perform();
//		}
		
		driver.findElement(By.xpath("//div[@class='filter-options']/div["+i+"]/div[2]/ol/li["+j+"]")).click();
		
		Resources.verifyLoadCount(3,Resources.getTotalCount(), count);
		
		String brandName =brandNames.get(j-1);
		
		println(brandName);
		
		Resources.verifyProductNames(brandName);
		
		driver.findElement(By.xpath("//div[@class='filter-options']/div["+i+"]/div[2]/ol/li["+j+"]")).click();
		
		flag=true;
		}
	}
	
	if(flag){
		
		break;
	}
}

println(brandNames);


